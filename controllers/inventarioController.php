<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\userModel as user;
use models\sucursalModel as sucursal;
use models\adminModel as admin;
use controllers\uploadsController as upload;
//Funciones de ayuda
use config\helper as help;
use Dompdf\Dompdf;
use Dompdf\Options;

// new Picqer\Barcode\BarcodeGeneratorPNG();
// la clase debe llamarse igual que el controlador respetando mayusculas
class inventarioController extends view

{

  public function index($var)
  {
    $dbs = $GLOBALS['DB_NAME'];
    $icon = help::icon();
    $categorias = product::getCategory($dbs);
    $cat_precios = admin::getCategoriaPrecios($dbs);
    $ofertas = admin::getAllOfertas();
    $listaTiendas = admin::getAllTiendas();
    // 
    //$categorias = product::getCategory();
    $tallas = product::getTallas($dbs);
    // $products = product::getProducts();
    $products = product::searchProduct("", 1, 1);
    $descuentos = product::getDescuentos();
    $data["products"] = $products['data'];
    $data["ofertas"] = $ofertas['data'];
    $paginationInfo =  $products;
    unset($paginationInfo['data']);
    $data["paginationInfo"] = $paginationInfo;
    $data["descuentos"] = $descuentos['data'];
    if (!isset($categorias['data'])) {
      $data["categorias"] = $categorias;
      $data["cat_precios"] = $cat_precios;
      $data["tallas"] = $tallas;
      $data["hasMoreDb"] = true;
    } else {
      $data["categorias"] = $categorias['data'];
      $data["cat_precios"] = $cat_precios['data'];
      $data["tallas"] = $tallas['data'];
      $data["hasMoreDb"] = false;
    }
    $data["icons"] =  $icon['icons'];
    $data["tiendas"] =  $listaTiendas;
    echo view::renderElement('inventario/ListaProductos', $data);
  }
  public function getproductTraslado($var)
  {
    $codigo = $_POST['codigo'];

    $productos = admin::getproduct($codigo);
    $icon = help::icon();
    $data['data'] = $productos['data']; // se pone de primero para que las variables se creen en el primer nivel
    $data["icons"] =  $icon['icons']; //las segundas se agregan despues para evitar ser borradas
    if ($productos['rows'] == 1) {
      view::renderElement('inventario/tableTrasladoSearch', $data);
    } else {
      echo '0';
    }
  }
  public function getTraslado($var)
  {
    /**
     *  Estados
     * 1: Pendiente
     * 2: Cancelado
     * 3: devolucion
     * 4: entregado
     */

    /**
     *  aceptado
     * 0: sin aceptar
     * 1: aceptadoTraslado
     * 2: AceptadoDevolucion
     */
    $traslados = product::getTraslados();
    $icon = help::icon();
    $data['traslados'] = $traslados['data'];
    $data["icons"] =  $icon['icons'];
    echo view::renderElement('inventario/tablaTraslados', $data);
  }
  public function getTrasladobyId($var)
  {
    /**
     *  Estados
     * 1: Pendiente
     * 2: Cancelado
     * 3: devolucion
     * 4: entregado
     */

    /**
     *  aceptado
     * 0: sin aceptar
     * 1: aceptadoTraslado
     * 2: AceptadoDevolucion
     */
    $id = $_POST['id'];
    $traslados = product::getTrasladobyId($id);
    $data['data'] = $traslados['data'];
    view::renderElement('inventario/trasladoDetail', $data);
  }
  public function insertTraslado($var)
  {
    /**
     *  Estados
     * 1: Pendiente
     * 2: Cancelado
     * 3: devolucion
     * 4: entregado
     */

    /**
     *  aceptado
     * 0: sin aceptar
     * 1: aceptadoTraslado
     * 2: AceptadoDevolucion
     */
    $comentario = $_POST['comentario'];
    $tiendaData = explode(";", $_POST['tienda_traslado']);
    $dbOrigen = $GLOBALS["DB_NAME"][$_SESSION['db']];
    $dbTienda = $tiendaData[0];
    $tienda_traslado =  $tiendaData[1];
    $productos = json_decode($_POST['productos'], true);
    $traslado = product::insertTraslado($dbOrigen, $tienda_traslado, $productos, $comentario, $dbTienda);

    if ($traslado['error'] == '00000') {
      admin::saveLog("Agregar", "Inventario",  "Se creo el traslado: " . $traslado['data']['id'], json_encode($_POST), $_SESSION['id']);
    } else {
      admin::saveLog("Error", "Inventario",  "Error al crear el traslado: " . $traslado['data']['id'], json_encode($_POST), $_SESSION['id']);
    }
    header('Content-Type: application/json');
    echo json_encode($traslado);
  }
  public function acceptTraslado($var)
  {
    /**
     *  Estados
     * 1: Pendiente
     * 2: Cancelado
     * 3: devolucion
     * 4: entregado
     */

    /**
     *  aceptado
     * 0: sin aceptar
     * 1: aceptadoTraslado
     * 2: AceptadoDevolucion
     */
    $id = $_POST['id'];
    $dbOrigen = $_POST['dbOrigen'];
    $dbTraslado = $_POST['dbTraslado'];
    $codigos = $this->getCodesFromStringTraslado($_POST['codigos']);

    $traslado = product::acceptTraslado($id, $dbOrigen, $dbTraslado, $codigos);
    header('Content-Type: application/json');
    echo json_encode($traslado);
  }
  public function getCodesFromStringTraslado(string $codigos): array
  {
    $arrayCodes = explode(";", $codigos);
    return $arrayCodes;
  }
  public function devolucionTrasladoBtn($var)
  {
    /**
     *  Estados
     * 1: Pendiente
     * 2: Cancelado
     * 3: devolucion
     * 4: entregado
     */

    /**
     *  Aceptado
     * 0: sin aceptar
     * 1: aceptadoTraslado
     * 2: AceptadoDevolucion
     */
    $id = $_POST['id'];
    $dbOrigen = $_POST['dbOrigen'];
    $dbTraslado = $_POST['dbTraslado'];
    $codigos = $this->getCodesFromStringTraslado($_POST['codigos']);

    $traslado = product::devolucionTrasladoBtn($id, $dbOrigen, $dbTraslado, $codigos);
    header('Content-Type: application/json');
    echo json_encode($traslado);
  }
  public function cancelarTraslado($var)
  {
    $id = $_POST['id'];
    $dbOrigen = $_POST['dbOrigen'];
    $dbTraslado = $_POST['dbTraslado'];
    $codigos = $this->getCodesFromStringTraslado($_POST['codigos']);

    $traslado = product::cancelarTraslado($id, $dbOrigen, $dbTraslado, $codigos);

    if ($traslado['error'] == '00000') {
      admin::saveLog("Cancelar", "Inventario",  "Se cancelo el traslado: " . $traslado['data']['id'], json_encode($_POST), $_SESSION['id']);
    } else {
      admin::saveLog("Error", "Inventario",  "Error al cancelar el traslado: " . $traslado['data']['id'], json_encode($_POST), $_SESSION['id']);
    }
    header('Content-Type: application/json');
    echo json_encode($traslado);
  }
  public function addstock($var)
  {
    $icon = help::icon();
    $products = product::searchProduct('', 1, 1);
    $data["products"] = $products['data'];
    $paginationInfo =  $products;
    unset($paginationInfo['data']);
    $data["paginationInfo"] = $paginationInfo;
    $data["icons"] =  $icon['icons'];
    //echo view::renderElement('inventario/productosTableStock', $data);
    echo view::renderElement('inventario/addstock', $data);
  }
  public function saveProductPrice($var)
  {
    try {
      $data = array(
        ':id' => $_POST['id'],
        ':costo' => $_POST['costo'],
        ':venta' => $_POST['venta'],
        ':unitario' => $_POST['unitario'],
        ':sugerido' => $_POST['sugerido']
      );

      $precioVentaNew = $_POST['venta'];

      $userPermisos = user::getRolUserAndPermisos($_SESSION['id']);
      $permisos = json_decode($userPermisos['data']['permisos'], true);
      $hasPermiso = array_key_exists("modificar_precio", $permisos);

      $productoIsNew =  product::getProductColumnDataByID($_POST['id'], 'isNew, precio_venta')['data'];

      $canSavePrices = false;

      switch ($productoIsNew['isNew']) {
        case '1':
          $canSavePrices = true; // si es nuevo se puede modificar el precio por que es un producto nuevo y no necesita permisos
          break;
        case '0':
          if ($productoIsNew['precio_venta'] != $precioVentaNew && $hasPermiso) {
            $canSavePrices = true; // si el precio es diferente y tiene permisos se puede modificar el precio
          } else if ($productoIsNew['precio_venta'] == $precioVentaNew) {
            $canSavePrices = true; // si el precio es igual se puede modificar el precio por que no existe cambio y no necesita permisos
          } else if ($productoIsNew['precio_venta'] != $precioVentaNew && !$hasPermiso) {
            $canSavePrices = false; // si el precio es diferente y no tiene permisos no se puede modificar el precio
          } else {
            $canSavePrices = true;
          }
          break;
      }

      if ($canSavePrices) {
        $stock = product::saveProductPrice($data);
        $datos = json_encode($stock);

        if ($stock['error'] == '00000') {
          admin::saveLog("Actualizar", "Inventario",  "Se actualizo los datos de precios del producto ID: " . $_POST['id'], $datos, $_SESSION['id']);
        } else {
          admin::saveLog("Error", "Inventario",  "Error al actualizar los datos de precios del producto ID: " . $_POST['id'], $datos, $_SESSION['id']);
        }

        header('Content-Type: application/json');
        echo json_encode($stock);
      } else {

        admin::saveLog("Error", "Inventario",  "Error al actualizar los datos de precios del producto ID: " . $_POST['id'], json_encode(array("error" => "ER001", "msg" => "No tiene permisos")), $_SESSION['id']);

        header('Content-Type: application/json');
        echo json_encode(array("error" => "ER001", "msg" => "No tiene permisos"));
      }
    } catch (\Throwable $th) {
      header('Content-Type: application/json');
      echo json_encode(array("error" => $th));
    }
  }

  public function updateStock($var)
  {
    $data = array(
      ':id' => $_POST['id'],
      ':stock' => $_POST['stock'],
    );
    $stock = product::updateStock($data);
    $datos = json_encode($data);
    if ($stock['error'] == '00000') {
      admin::saveLog("Actualizar", "Inventario",  "Se actualizo el Stock del producto ID: " . $_POST['id'], $datos, $_SESSION['id']);
    } else {
      admin::saveLog("Error", "Inventario",  "Error al actualizar el Stock del producto ID: " . $_POST['id'], $datos, $_SESSION['id']);
    }
    header('Content-Type: application/json');
    echo json_encode($stock);
  }
  public function updateMinStock($var)
  {
    $data = array(
      ':id' => $_POST['id'],
      ':MinStock' => $_POST['MinStock'],
    );
    $stock = product::updateMinStock($data);
    $datos = json_encode($data);
    if ($stock['error'] == '00000') {
      admin::saveLog("Actualizar", "Inventario",  "Se actualizo el Stock Minimo del producto ID: " . $_POST['id'], $datos, $_SESSION['id']);
    } else {
      admin::saveLog("Error", "Inventario",  "Error al actualizar el Stock Minimo del producto ID: " . $_POST['id'], $datos, $_SESSION['id']);
    }
    header('Content-Type: application/json');
    echo json_encode($stock);
  }
  public function refreshProductstock($var)
  {
    $toSearch = $_POST['toSearch'];
    $estado = $_POST['estado'];
    $icon = help::icon();
    $products = product::searchProduct($toSearch, 1, $estado);
    $data["products"] = $products['data'];
    $paginationInfo =  $products;
    unset($paginationInfo['data']);
    $data["paginationInfo"] = $paginationInfo;
    $data["icons"] =  $icon['icons'];
    echo view::renderElement('inventario/productosTableStock', $data);
  }
  public function generarCodigo($var)
  {
    try {
      $codigo = help::generarCodigo(7);
      header('Content-type: application/json');
      echo json_encode(array("codigo" => $codigo));
    } catch (\Throwable $th) {
      echo json_encode(array("error" => $th));
    }
  }
  public function producttable($var)
  {
    $estado = $_POST['estado'];
    $icon = help::icon();
    $categorias = product::getCategory();
    $tallas = product::getTallas();
    $products = product::searchProduct('', (isset($_POST['pagination']) ? $_POST['pagination'] : 1), $estado);
    $cat_precios = admin::getCategoriaPrecios();
    $descuentos = product::getDescuentos();
    $data["products"] = $products['data'];
    $paginationInfo =  $products;
    unset($paginationInfo['data']);
    $data["paginationInfo"] = $paginationInfo;
    $data["descuentos"] = $descuentos['data'];
    $data["cat_precios"] = $cat_precios['data'];
    $data["categorias"] = $categorias['data'];
    $data["tallas"] = $tallas['data'];
    $data["icons"] =  $icon['icons'];
    echo view::renderElement('inventario/productosTable', $data);
  }
  public function getProductById($var)
  {

    $products = product::getProductById($_POST['idproducto']);
    header('Content-Type: application/json');
    echo json_encode($products);
  }

  public function searchProduct($var)
  {
    $toSearch = $_POST['toSearch'];
    $estado = $_POST['estado'];
    $icon = help::icon();
    $products = product::searchProduct($toSearch, (isset($_POST['pagination']) ? $_POST['pagination'] : 1), (isset($estado) ? $estado : 1));
    $categorias = product::getCategory();
    $tallas = product::getTallas();
    $cat_precios = admin::getCategoriaPrecios();
    $descuentos = product::getDescuentos();
    $data["products"] = $products['data'];
    $paginationInfo =  $products;
    unset($paginationInfo['data']);
    $data["paginationInfo"] = $paginationInfo;
    $data["descuentos"] = $descuentos['data'];
    $data["cat_precios"] = $cat_precios['data'];
    $data["categorias"] = $categorias['data'];
    $data["tallas"] = $tallas['data'];
    $data["icons"] =  $icon['icons'];
    echo view::renderElement('inventario/productosTable', $data);
  }

  public function searchProductstock($var)
  {
    $toSearch = $_POST['toSearch'];
    $estado = $_POST['estado'];
    $icon = help::icon();
    $products = product::searchProduct($toSearch, (isset($_POST['pagination']) ? $_POST['pagination'] : 1), $estado);
    $paginationInfo =  $products;
    unset($paginationInfo['data']);
    $data["paginationInfo"] = $paginationInfo;
    $data["products"] = $products['data'];
    $data["icons"] =  $icon['icons'];
    echo view::renderElement('inventario/productosTableStock', $data);
  }

  public function addproduct()
  {
    $dbs = explode(";", $_POST['dbs']);
    $combos = explode(";", $_POST['combos']);
    $sameCode = help::validarCodeAllDBs($_POST["codigoBarras"], $dbs);
    if (!$sameCode) {
      $datos = array(
        ":descripcion" => $_POST["descripcion"],
        ":descripcion_short" => $_POST["descripcion_short"],
        ":marca" => $_POST["marca"],
        ":estilo" => $_POST["estilo"],
        ":categoria" => null,
        ":codigoBarras" =>  $_POST["codigoBarras"],
        ":talla" => null,
        ":iva_valor" => ((int) $_POST["iva_valor"] > 0 ? (int)$_POST["iva_valor"] : 0),
        ":iva" => (isset($_POST["iva"]) ? 1 : 0),
        ":idusuario" => (int) $_SESSION["id"],
        ":modificado_por" => (int) $_SESSION["id"],
        ":estado" => (isset($_POST["estado"]) ? 1 : 0),
        ":categoriaPrecio" => null,
        ":urls" => $_POST["urls"]
      );
      $urls = upload::uploads();
      $datos[":urls"] = implode(",", $urls['urls']);
      $addProduct = product::Addproduct($datos, $dbs, $combos);

      if ($addProduct['error'] == '00000') {
        admin::saveLog("Agregar", "Inventario",  "Se agrego el producto: " . $_POST['descripcion'], json_encode($datos), $_SESSION['id']);
      } else {
        admin::saveLog("Error", "Inventario",  "Error al agregar el producto: " . $_POST['descripcion'], json_encode($datos), $_SESSION['id']);
      }

      header('Content-Type: application/json');
      echo json_encode($addProduct);
    } else {
      header('Content-Type: application/json');
      echo json_encode(array("error" => 2, "msg" => "Ya existe el codigo en una de las Tiendas seleccionadas, Genere uno nuevo por favor"));
    }
  }

  public function updateProduct($var)
  {
    if ($_FILES['file']['name'][0] !== '') {
      $urlImg = upload::uploads();
      $urls = implode(",", $urlImg['urls']);
    } else {
      $urls = '';
    }
    $datos = array(
      ":descripcion" => $_POST["descripcion"],
      ":descripcion_short" => $_POST["descripcion_short"],
      ":marca" => $_POST["marca"],
      ":estilo" => $_POST["estilo"],
      ":categoria" => (int) $_POST["categoria"],
      ":talla" => (int)$_POST["talla"],
      ":codigoBarras" => $_POST["codigoBarras"],
      ":iva_valor" => ((int) $_POST["iva_valor"] > 0 ? (int)$_POST["iva_valor"] : 0),
      ":iva" => (isset($_POST["iva"]) ? 1 : 0),
      ":modificado_por" => (int) $_SESSION["id"],
      ":urls" => $urls,
      ":idproducto" => (int) $_POST["idproducto"],
      ":categoriaPrecio" => $_POST["categoriaPrecio"],
      ":descuento" => $_POST["descuento"],
      ":idOferta" => $_POST["idOferta"],
      ":estado" => (isset($_POST["estado"]) ? 1 : 0),
    );

    $updateProduct = product::updateProduct($datos);
    $unlinkState = upload::removeImgAdd($_POST["urlsToDelete"]);
    $updateProduct['unlinkState'] = $unlinkState['data'];

    if ($updateProduct['error'] == '00000') {
      admin::saveLog("Actualizar", "Inventario",  "Se actualizo el producto: " . $_POST['descripcion'], json_encode($datos), $_SESSION['id']);
    } else {
      admin::saveLog("Error", "Inventario",  "Error al actualizar el producto: " . $_POST['descripcion'], json_encode($datos), $_SESSION['id']);
    }

    header('Content-Type: application/json');
    echo json_encode($updateProduct);
  }
  public function calcular_sugerido($var)
  {
    $id = $_POST['id'];
    $datos[':id'] = $id;
    $resultFactor = product::getFactorProductById($datos);
    $resultGastos = admin::getGastos();
    $gastos = $resultGastos['data'];
    $factor = $resultFactor['data']['factor'];
    $tipo_cambio = 600;
    $sugerido = 0;
    $costo_en_dolar = (float) $_POST['costo'];
    $unitario = (float) $_POST['unitario'];
    $total_gasto_admin = (float) $gastos['total'];
    // Se suman todos los ingresos
    $total_ingresos = (float)($gastos['efectivo'] + $gastos['tarjeta'] + $gastos['transferencia']);

    //Se calcula el porcentaje de gastos
    $result_porcent_gastos = (float)($total_gasto_admin / $total_ingresos);

    $costo_administrativo_unitario = (float)round(($unitario * $result_porcent_gastos), 2);

    //Calculamos el precio del flete x Kilo respecto al factor
    $p_fleteXkilo = ($factor * 7.0);
    $costo_en_dolar_mas_flete = ($costo_en_dolar + $p_fleteXkilo);
    $costo_en_colones = $costo_en_dolar_mas_flete * $tipo_cambio;
    $precio_sin_utilidad = $costo_en_colones + $costo_administrativo_unitario;
    $utilidad = round(($precio_sin_utilidad * 0.40), 2);
    $precio_sugerido = (float) ($precio_sin_utilidad + $utilidad);
    header('Content-Type: application/json');
    echo json_encode(array(
      "precio_sugerido" => $precio_sugerido,
    ));
  }
  public function indexEtiquetas()
  {
    $icon = help::icon();
    $data["icons"] =  $icon['icons'];
    echo view::renderElement('inventario/etiquetas', $data);
  }
  public function disableProduct()
  {
    $result = product::disableProduct($_POST['id'], $_POST['estado']);

    if ($result['error'] == '00000') {
      admin::saveLog("Actualizar", "Inventario",  "Se actualizo el estado del producto ID: " . $_POST['id'], json_encode($_POST), $_SESSION['id']);
    } else {
      admin::saveLog("Error", "Inventario",  "Error al actualizar el estado del producto ID: " . $_POST['id'], json_encode($_POST), $_SESSION['id']);
    }

    header('Content-Type: application/json');
    echo json_encode($result);
  }
}
