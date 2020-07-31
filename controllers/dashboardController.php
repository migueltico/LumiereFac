<?php

namespace controllers;
// manda a llamar al controlador de vistas
 use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\conexion;
//Funciones de ayuda
use Config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class dashboardController extends view

{
   
    public function index($var)
    {
        $var["Variable"] ="NewArr";
        $block =array("dashboard/body");
        view::renderT("main",  $block, help::icon());
        
    }
   
}
