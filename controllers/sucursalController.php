<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\sucursalModel as sucursal;
//Funciones de ayuda
use Config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class sucursalController extends view

{

  public function index($var)
  {    
    $sucursal = sucursal::getSucursal();
    $var["sucursales"] = $sucursal['data'];    
    view::renderElement('sucursales', $var);
  }
  public function addSucursal($var)
  {    
    $data = array(
      ":descripcion"=>$_POST["descripcion"],
      ":ubicacion"=>$_POST["ubicacion"],
      ":telefono"=>$_POST["telefono"],
      ":creado_por"=>$_SESSION["id"],
      ":descripcion"=>$_SESSION["id"]
    );
    $sucursal = sucursal::setSucursal($data);
  }

}
