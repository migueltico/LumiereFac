<?php

namespace controllers;
// manda a llamar al controlador de vistas
use Config\view;
use models\userModel as user;
//Funciones de ayuda
use Config\helper as help;
// manda a llamar al controlador de conexiones a bases de datos

// la clase debe llamarse igual que el controlador respetando mayusculas
class loginController extends view

{
    public function index($var)
    {
        view::render("login/index", $var);
    }
    public function logout($var)
    {
        session_destroy();
        help::redirect("/");
    }
    public function validar($var)
    {
        $post =  $var['post'];
        $data = user::getUser($post['usuario'], $post['pass']);
        if ($data['rows'] == 1) {
            $data = $data['data'];
            $_SESSION["id"] = $data["idusuario"];
            $_SESSION["usuario"] = $data["usuario"];
            $_SESSION["nombre"] = $data["nombre"];
            $_SESSION["rol"] = $data["rol"];
            $_SESSION["sucursal"] = $data["sucursal"];
            $_SESSION["idsucursal"] = $data["idsucursal"];
            //return json_encode(array("estado" => 200, "session" => $_SESSION));
            help::redirect("/dashboard");
        } else {
            
            //return json_encode(array("estado" => 400, "error" =>"No coincide con ningun usuario"));
            help::redirect("/");
        }
    }
}
