<?php

namespace middleware;

use models\userModel as user;
use models\adminModel as admin;
//Funciones de ayuda
use config\helper as h;

class loginMiddleware
{
    public function auth($request = '', $next = '')
    {
        $url = $_SERVER['REQUEST_URI'];

        if (!isset($_SESSION['id'])) {
            if ($url !== "/") {
                h::redirect("/");
            }
            return ["return" => true, "send_json_error" => false, "send_msg" => false, "msg" => ""];
        } else {
            if ($url == "/") {
                h::redirect("/dashboard");
            }
            return ["return" => true, "send_json_error" => false, "send_msg" => false, "msg" => ""];
        }
    }
    public function updateSession()
    {
        if (!isset($_COOKIE['lsd_r']) && !isset($_SESSION["id"])) {
            return ["return" => true, "send_json_error" => false, "send_msg" => false, "msg" => ""];
        }
        $dataLogin = @explode(";", $_COOKIE['lsd_r']);
        if (isset($_SESSION["id"])) {

            $id = $_SESSION["id"];
        } else {
            $id = $dataLogin[0];
            $_SESSION["db"] = trim($dataLogin[4]);
        }
        $data = user::getUserById($id);

        $permisos = user::getPermisos($data['data']["idrol"]);
        $permisosJson = json_decode($permisos['data']['permisos'], true);
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
            //print_r($_SESSION);
        }
        return ["return" => true, "send_json_error" => false, "send_msg" => false, "msg" => ""];
    }
}
