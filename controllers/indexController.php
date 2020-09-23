<?php

namespace controllers;
// manda a llamar al controlador de vistas
 use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\conexion;
//Funciones de ayuda
use config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class indexController extends view

{
   
    public function dashboard($var)
    {
        $var["Variable"] ="NewArr";
        view::render("dashboard/index",$var);
        
    }
   
}
