<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\sucursalModel as sucursal;
//Funciones de ayuda
use config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class sucursalController extends view

{

  public function index($var)
  {
    $sucursal = sucursal::getAllSucursal();
    $var["sucursales"] = $sucursal['data'];
    view::renderElement('sucursal/sucursales', $var);
  }
  public function sucursaltable($var)
  {
    $sucursal = sucursal::getAllSucursal();
    $var["sucursales"] = $sucursal['data'];
    view::renderElement('sucursal/sucursaltable', $var);
  }
  public function deleteSucursal($var)
  {
    $sucursal = sucursal::createNewDataBAse('CCCCCC');
   // $sucursal = sucursal::deleteSucursal($_POST['idsucursal']);
    header('Content-Type: application/json');
    echo json_encode($sucursal);
  }
  public function addSucursal($var)
  {
    $data = array(
      ":sucursal" => $_POST["sucursal"],
      ":ubicacion" => $_POST["ubicacion"],
      ":tel" => $_POST["tel"],
      ":creado_por" => $_SESSION["id"],
      ":modificado_por" => $_SESSION["id"]
    );
    $sucursal = sucursal::setSucursal($data);
    header('Content-Type: application/json');
    echo json_encode($sucursal);
  }
  public function updateSucursal($var)
  {
    $data = array(
      ":sucursal" => $_POST["sucursal"],
      ":ubicacion" => $_POST["ubicacion"],
      ":tel" => $_POST["tel"],
      ":idsucursal" => $_POST["idsucursal"],
      ":modificado_por" => $_SESSION["id"]
    );
    $sucursal = sucursal::updateSucursal($data);
    header('Content-Type: application/json');
    echo json_encode($sucursal);
  }
  public function getSucursalById($var)
  {
    $sucursal = sucursal::getSucursalById($_POST['idsucursal']);
    header('Content-Type: application/json');
    echo json_encode($sucursal);
  }

}
