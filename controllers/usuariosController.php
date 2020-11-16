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
        echo view::renderElement('usuarios/usuarios', $data);
    }
    public function setUser($var)
    {
        $nombre = explode(" ", $_POST['nombre']);
        $firstChart = substr($nombre[0], 0, 1);
        $apellido = strtolower((isset($nombre[1]) ? $nombre[1] : $nombre[0]));
        $usuario = $firstChart . $apellido . help::randLetterNumber(2);
        $datos[':usuario'] = $usuario;
        $datos[':nombre'] = $_POST['nombre'];
        $datos[':email'] = $_POST['correo'];
        $datos[':telefono'] = $_POST['telefono'];
        $datos[':direccion'] = $_POST['direccion'];
        $datos[':estado'] = 2;
        $datos[':rol'] = (isset($_POST['rol']) ? $_POST['rol'] : 0);
        $datos[':identificador'] = help::randLetterNumber(8);
        $users = users::setUsers($datos);
        header('Content-Type: application/json');
        echo json_encode($users);
    }
    public function getNewPassword($var)
    {
        $icon = help::icon();
        $params = $var['params'];
        $_SESSION["db"] = $params['db'];
        $validate = users::validatePassRequest($params['identificador']);
        if ($validate['rows'] > 0) {
            $data['data'] = $validate['data'];
            $data['params'] = $params;
            echo view::renderElement('usuarios/getPassword', $data);
        } else {
            echo view::renderError('error404Link');
        }
    }
    public function verIdentificador($var)
    {
        $identificador = users::GetIdentificador($_POST['id']);
        $identificador['data']['server'] = $_SERVER['SERVER_NAME'];
        $identificador['data']['db'] = $_SESSION["db"];
        header('Content-Type: application/json');
        echo json_encode($identificador);
    }
    public function setNewPassword($var)
    {
        $cpass = $_POST['cPass'];
        $npass = $_POST['nPass'];
        $hash = hash('sha256', $npass);
        $result = [];
        if ($cpass == $npass) {
            $data[':id'] = $_POST['id'];
            $data[':pass'] = $hash;
            $result = users::setPass($data);
        } else {
            $result = ['error' => "001200"];
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
