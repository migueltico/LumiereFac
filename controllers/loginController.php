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
        setcookie("lsd_r", "", time() - 10);
        help::redirect("/");
    }
    public function getPermisos($var)
    {
        $permisos = user::getPermisos($_SESSION["idrol"]);
        $permisosJson = json_decode($permisos['data']['permisos'], true);
        header('Content-Type: application/json');
        echo json_encode($permisosJson);
    }
    public function changePasswordUser($var)
    {
        try {
            $get =(Object)$var['params'];
        
            $response = user::changePasswordUser($get->user,$this->generarEncriptacion("123"));
            //respose= {"rows":1,"data":false,"estado":true,"error":"00000","errorMsg":["00000",null,null]}
            if($response['estado'] && $response['error'] == 00000){
                $this->render("forcedChangePassword",array("user"=>$get->user,"pass"=>"123"));
            }else{
                echo json_encode(array("estado" => false, "error" => "Error con la Base de datos, por favor comuniquese con el encargado 0", $response));
            }
        } catch (\Throwable $th) {
            echo json_encode(array("estado" => false, "error" => "Error con la Base de datos, por favor comuniquese con el encargado 1", $th->getMessage()));
        }
     

    }
    public function generarEncriptacion($dato)
{
    $hash = hash('sha256', $dato);
    return $hash;
}

    public function validar($var)
    {
        $post =  $var['post'];
        try {
            //code...

            if (!empty($post["db"]) && !empty($post["usuario"]) && !empty($post["pass"])) {
                $_SESSION["db"] = $post["db"];
                if ($post["db"] == 'TestDB') {
                    $GLOBALS["env_test"] = true;
                }
                $hash = hash('sha256', $post['pass']);
                $data = user::getUser($post['usuario'], $hash);
                $estado = false;
                if ($data['rows'] == 1) {
                    $estado = $data['data']['estado'] == 1 ? true : false;
                }
                if ($data['rows'] == 1 && $estado) {
                    $permisos = user::getPermisos($data['data']["idrol"]);
                    $permisosJson = json_decode($permisos['data']['permisos'], true);
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
                    $data = $data["idusuario"] . ";" . $data["usuario"] . ";" . $data["nombre"] . ";" . $data["idrol"] . ";" . $post["db"];
                    setcookie("lsd_r", $data, strtotime('+1 days'));
                    //return json_encode(array("estado" => 200, "session" => $_SESSION));
                    //help::redirect("/dashboard");
                    echo json_encode(array("estado" => true, "msg" => "Login Exitoso"));
                } else {

                    echo json_encode(array("estado" => false, "error" => "Usuario o contraseña no coinciden"));
                    //help::redirect("/");
                }
            } else {
                echo json_encode(array("estado" => false, "error" => "Campos incompletos"));
            }
        } catch (\Throwable $th) {
            echo json_encode(array("estado" => false, "error" => "Error con la Base de datos, por favor comuniquese con el encargado"));
        }
    }
}
