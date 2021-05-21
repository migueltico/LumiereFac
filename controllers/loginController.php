<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
use models\userModel as user;
use models\clientesModel as cliente;
use models\adminModel as admin;
//Funciones de ayuda
use config\helper as help;
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
    public function getPermisos($var)
    {
        $permisos = user::getPermisos($_SESSION["idrol"]);
        $permisosJson = json_decode($permisos['data']['permisos'],true);
        header('Content-Type: application/json');
        echo json_encode($permisosJson);
    }
    public function validar($var)
    {
        $post =  $var['post'];
        if (!empty($post["db"]) && !empty($post["usuario"]) && !empty($post["pass"])) {
            $_SESSION["db"] = $post["db"];
            if($post["db"]=='TestDB'){
                $GLOBALS["env_test"]=true;
            }
            $hash = hash('sha256', $post['pass']);
            $data = user::getUser($post['usuario'], $hash);
            
            $permisos = user::getPermisos($data['data']["idrol"]);
            $permisosJson = json_decode($permisos['data']['permisos'],true);
            if ($data['rows'] == 1) {
                $info = admin::infoSucursal();
                $info = $info['data'];
                $data = $data['data'];
                $_SESSION["id"] = $data["idusuario"];
                $_SESSION["usuario"] = $data["usuario"];
                $_SESSION["nombre"] = $data["nombre"];
                $_SESSION["rolname"] = $data["rolname"];
                $_SESSION["idrol"] = $data["idrol"];
                $_SESSION["info"] = $info;
                $_SESSION["permisos"] = $permisosJson;

                //return json_encode(array("estado" => 200, "session" => $_SESSION));
                help::redirect("/dashboard");
            } else {

                //return json_encode(array("estado" => 400, "error" =>"No coincide con ningun usuario"));
                help::redirect("/");
            }
        } else {
            echo "ERROR LOGIN";
        }
    }
}
