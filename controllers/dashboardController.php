<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\conexion;
//Funciones de ayuda
use config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class dashboardController extends view

{

    public function index($var)
    {
        $var["Variable"] = "NewArr";
        $block = array("dashboard/body");
        view::renderT("main",  $block, help::icon());
    }
    public function general($var)
    {
         $icon = help::icon();
        // $users = users::getUsers();
        // $rols = users::getRols();
        // $data["icons"] =  $icon['icons'];
        // $data["users"] =  $users['data'];
        // $data["rols"] =  $rols['data'];
        echo view::renderElement('dashboard/dashboard');
    }
}
