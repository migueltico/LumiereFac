<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\sucursalModel as sucursal;
use controllers\uploadsController as upload;
//Funciones de ayuda
use Config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class inventarioController extends view

{

  public function index($var)
  {
    $icon = help::icon();
    $categorias = product::getCategory();
    $tallas = product::getTallas();
    $sucursal = sucursal::getSucursal();
    $products = product::getProductsBySucursal($_SESSION['idsucursal']);
    $data["categorias"] = $categorias['data'];
    $data["tallas"] = $tallas['data'];
    $data["sucursal"] = $sucursal['data'];
    $data["products"] = $products['data'];
    $data["icons"] =  $icon['icons'];
    echo view::renderElement('inventario/ListaProductos', $data);
  }

  public function generarCodigo($var)
  {
    try {
      $codigo = help::generarCodigo(11);
      header('Content-type: application/json');
      echo json_encode(array("codigo" => $codigo));
    } catch (\Throwable $th) {
      echo json_encode(array("error" => $th));
    }
  }
  public function producttable($var)
  {
    $icon = help::icon();
    $categorias = product::getCategory();
    $tallas = product::getTallas();
    $sucursal = sucursal::getSucursal();
    $products = product::getProductsBySucursal($_SESSION['idsucursal']);
    $data["categorias"] = $categorias['data'];
    $data["tallas"] = $tallas['data'];
    $data["sucursal"] = $sucursal['data'];
    $data["products"] = $products['data'];
    $data["icons"] =  $icon['icons'];
    echo view::renderElement('inventario/productosTable', $data);
  }
  public function getProductBySucursal($var)
  {

    $products = product::getProductBySucursal($_POST['idproducto']);
    header('Content-Type: application/json');
    echo json_encode($products);
  }

  public function addproduct($var)
  {
    $sucursal = $_POST["sucursales"];
    $codigo = $_POST["codigoBarras"];
    $sucursal = explode(",", $sucursal);
    $addProduct = '';
    $datos = array(
      ":descripcion" => $_POST["descripcion"],
      ":marca" => $_POST["marca"],
      ":estilo" => $_POST["estilo"],
      ":categoria" => (int) $_POST["categoria"],
      ":codigoBarras" => $codigo,
      ":talla" => (int)$_POST["talla"],
      ":iva_valor" => ((int) $_POST["iva_valor"] > 0 ? (int)$_POST["iva_valor"] : 0),
      ":iva" => (isset($_POST["iva"]) ? 1 : 0),
      ":idusuario" => (int) $_SESSION["id"],
      ":modificado_por" => (int) $_SESSION["id"],
      ":urls" => $_POST["urls"],
    );
    $urls = upload::uploads();
    $datos[":urls"] = implode(",", $urls['urls']);
    $addProduct = product::Addproduct($datos, $sucursal);
    header('Content-Type: application/json');
    //echo json_encode(array($datos, $urls, $sucursal));
    echo json_encode($addProduct);
  }

  public function updateProduct($var)
  {
    $sucursal = $_POST["sucursales"];
    $codigo = $_POST["codigoBarras"];
    $sucursal = explode(",", $sucursal);
    $urlImg = upload::uploads();
    $urls= implode(",", $urlImg['urls']);
    $datos = array(
      ":descripcion" => $_POST["descripcion"],
      ":marca" => $_POST["marca"],
      ":estilo" => $_POST["estilo"],
      ":categoria" => (int) $_POST["categoria"],
      ":talla" => (int)$_POST["talla"],
      ":codigoBarras" => $_POST["codigoBarras"],
      ":iva_valor" => ((int) $_POST["iva_valor"] > 0 ? (int)$_POST["iva_valor"] : 0),
      ":iva" => (isset($_POST["iva"]) ? 1 : 0),
      ":modificado_por" => (int) $_SESSION["id"],
      ":urls" => $urls ,
      ":idproducto" => (int) $_POST["idproducto"],
    );

    $updateProduct = product::updateProduct($datos, $sucursal);
    header('Content-Type: application/json');
    echo json_encode($updateProduct);
  }
}
