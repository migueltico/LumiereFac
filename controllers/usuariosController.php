<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\sucursalModel as sucursal;
use models\adminModel as admin;
use models\usuariosModel as users;
use models\rolesModel as rols;
use models\facturacionModel as fac;
use Dompdf\Dompdf;
use Dompdf\Options;
//Funciones de ayuda
use config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class usuariosController extends view

{

    public function index($var)
    {
        $icon = help::icon();
        $users = users::getUsers();
        $rols = rols::getRols();
        $data["icons"] =  $icon['icons'];
        $data["users"] =  $users['data'];
        $data["rols"] =  $rols['data'];
        echo view::renderElement('usuarios/usuarios',$data);
    }
    public function setUser($var)
    {
        $datos[":urls"] = implode(",", $urls['urls']);
       // $users = users::setUsers($datos);
        header('Content-Type: application/json');
        //echo json_encode(array($datos, $urls, $sucursal));
        echo json_encode($_POST);
    }
}
