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
        if ($users['error'] == '00000') {
            admin::saveLog('Nuevo', 'Usuarios', 'Se creo el usuario ' . $_POST['nombre'], json_encode($datos), $_SESSION["id"]);
        } else {
            admin::saveLog('Error', 'Usuarios', 'Error al crear el usuario ' . $_POST['nombre'], json_encode($datos), $_SESSION["id"]);
        }
        header('Content-Type: application/json');
        echo json_encode($users);
    }
    public function editUser($var)
    {
        $hasPermission = array_key_exists("usuarios_editar_rol", $_SESSION['permisos']);
        $datos[':id'] = $_POST['id'];
        $datos[':nombre'] = $_POST['nombre'];
        $datos[':email'] = $_POST['correo'];
        $datos[':telefono'] = $_POST['telefono'];
        $datos[':direccion'] = $_POST['direccion'];
        $refreshusers = '';
        if (!isset($_POST['rol'])) {

            $refreshusers = users::getUserById($_POST['id']);
            $refreshusers = $refreshusers['data']['rol'];
            $datos[':rol'] = $refreshusers;
        } elseif (!$hasPermission) {
            $refreshusers = users::getUserById($_POST['id']);
            $refreshusers = $refreshusers['data']['rol'];
            $datos[':rol'] = $refreshusers;
        } else {
            $datos[':rol'] = $_POST['rol'];
        }
        $users = users::editUser($datos);

        if ($users['error'] == '00000') {
            admin::saveLog('Actualizar', 'Usuarios', 'Se actualizo el usuario ' . $_POST['nombre'], json_encode($datos), $_SESSION["id"]);
        } else {
            admin::saveLog('Error', 'Usuarios', 'Error al actualizar el usuario ' . $_POST['nombre'], json_encode($datos), $_SESSION["id"]);
        }
        header('Content-Type: application/json');
        echo json_encode($users);
    }
    public function editUserPerfil($var)
    {
        $user = trim($_POST['usuario']);
        $newUser = false;
        $same = true;
        $olduser = $_SESSION['usuario'];
        if ($user != $olduser) {
            $confirmUser = users::confirmUser($user);
            $same = false;
            $newUser = $confirmUser['rows'] == 0 ? true : false;
        }
        $datos[':id'] = $_POST['id'];
        $datos[':nombre'] = trim($_POST['nombre']);
        $datos[':email'] = $_POST['correo'];
        $datos[':telefono'] = $_POST['telefono'];
        $datos[':direccion'] = $_POST['direccion'];
        $user = $newUser ? $user : $olduser;
        $datos[':usuario'] = $user;
        $users = users::editUserPerfil($datos);
        if ($users["error"] == "00000" && $newUser) {
            $_SESSION['usuario'] = trim($_POST['usuario']);
        }
        $users["newuser"] = $newUser ? true : false;
        $users["olduser"] = $olduser;
        $users["same"] =  $same;
        if ($users['error'] == '00000') {
            admin::saveLog('Actualizar', 'Usuarios', 'Se actualizo el usuario ' . $_POST['nombre'], json_encode($datos), $_SESSION["id"]);
        } else {
            admin::saveLog('Error', 'Usuarios', 'Error al actualizar el usuario ' . $_POST['nombre'], json_encode($datos), $_SESSION["id"]);
        }
        header('Content-Type: application/json');
        echo json_encode($users);
    }
    public function updatePass($var)
    {
        $hash = hash('sha256', trim($_POST['newpass']));
        $datos[':id'] = $_POST['id'];
        $datos[':newpassword'] = $hash;
        $users = users::updatePass($datos);
        unset($datos[':newpassword']);
        if ($users['error'] == '00000') {

            admin::saveLog('Actualizar', 'Usuarios', 'Se actualizo la contraseña del usuario ' . $_POST['id'], json_encode($datos), $_SESSION["id"]);
        } else {

            admin::saveLog('Error', 'Usuarios', 'Error al actualizar la contraseña del usuario ' . $_POST['id'], json_encode($datos), $_SESSION["id"]);
        }
        header('Content-Type: application/json');
        echo json_encode($users);
    }
    public function confirmPassNow($var)
    {
        $hash = hash('sha256', trim($_POST['passnow']));
        $id = $_POST['id'];
        $users = users::confirmPassNow($id);
        $pass = $users['data']['password'];
        $users['data']['ok'] = $pass == $hash ? true : false;
        unset($users['data']['password']);
        header('Content-Type: application/json');
        echo json_encode($users);
    }
    public function getUserById($var)
    {
        $id = $_POST['id'];
        $users = users::getUserById($id);
        unset($users['data']['password']);
        header('Content-Type: application/json');
        echo json_encode($users);
    }
    public function getNewPassword($var)
    {
        $icon = help::icon();
        $params = $var['params'];
        $_SESSION["db"] = urldecode($params['db']);
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
    public function disableUser($var)
    {
        $data[':id'] = $_POST['id'];
        $data[':estado'] = 3;
        $result = users::disableUser($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
