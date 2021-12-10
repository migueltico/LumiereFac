<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
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
    $icon = help::icon();
    $categorias = product::getCategory();
    $cat_precios = admin::getCategoriaPrecios();
    $ofertas = admin::getAllOfertas();
    $listaTiendas = admin::getAllTiendas();
    // 
    //$categorias = product::getCategory();
    $tallas = product::getTallas();
    // $products = product::getProducts();
    $products = product::searchProduct("", 1, 1);
    $descuentos = product::getDescuentos();
    $data["products"] = $products['data'];
    $data["ofertas"] = $ofertas['data'];
    $paginationInfo =  $products;
    unset($paginationInfo['data']);
    $data["paginationInfo"] = $paginationInfo;
    $data["descuentos"] = $descuentos['data'];
    $data["categorias"] = $categorias['data'];
    $data["tallas"] = $tallas['data'];
    $data["cat_precios"] = $cat_precios['data'];
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
    $traslados = product::getTraslados();
    $data['traslados'] = $traslados['data'];
    echo view::renderElement('inventario/tablaTraslados', $data);
  }
  public function insertTraslado($var)
  {
    $comentario = $_POST['comentario'];
    $tiendaData = explode(";", $_POST['tienda_traslado']);
    $dbOrigen = $_SESSION['db'];
    $dbTienda = $tiendaData[0];
    $tienda_traslado =  $tiendaData[1];
    $productos = json_decode($_POST['productos'], true);
    $traslado = product::insertTraslado($dbOrigen, $tienda_traslado, $productos, $comentario, $dbTienda);
    // if($traslado['dbTraslate'] == "SUCCESS" && !$traslado['error'] ){

    // }
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
    $data = array(
      ':id' => $_POST['id'],
      ':costo' => $_POST['costo'],
      ':venta' => $_POST['venta'],
      ':unitario' => $_POST['unitario'],
      ':sugerido' => $_POST['sugerido']
    );
    $stock = product::saveProductPrice($data);
    $datos = json_encode($data);
    if ($stock['error'] == '00000') {
      admin::saveLog("Actualizar", "Inventario",  "Se actualizo los datos de precios del producto ID: " . $_POST['id'], $datos, $_SESSION['id']);
    }
    header('Content-Type: application/json');
    echo json_encode($stock);
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
    $datos = array(
      ":descripcion" => $_POST["descripcion"],
      ":descripcion_short" => $_POST["descripcion_short"],
      ":marca" => $_POST["marca"],
      ":estilo" => $_POST["estilo"],
      ":categoria" => (int) $_POST["categoria"],
      ":codigoBarras" =>  $_POST["codigoBarras"],
      ":talla" => (int)$_POST["talla"],
      ":iva_valor" => ((int) $_POST["iva_valor"] > 0 ? (int)$_POST["iva_valor"] : 0),
      ":iva" => (isset($_POST["iva"]) ? 1 : 0),
      ":idusuario" => (int) $_SESSION["id"],
      ":modificado_por" => (int) $_SESSION["id"],
      ":estado" => (isset($_POST["estado"]) ? 1 : 0),
      ":categoriaPrecio" => $_POST["categoriaPrecio"],
      ":urls" => $_POST["urls"]
    );
    $urls = upload::uploads();
    $datos[":urls"] = implode(",", $urls['urls']);
    $addProduct = product::Addproduct($datos);
    header('Content-Type: application/json');
    //echo json_encode(array($datos, $urls, $sucursal));
    echo json_encode($addProduct);
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
    header('Content-Type: application/json');
    echo json_encode($result);
  }
}
