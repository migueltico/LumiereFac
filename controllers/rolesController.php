<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\rolesModel as rols;
use Dompdf\Dompdf;
use Dompdf\Options;
use models\adminModel as admin;
//Funciones de ayuda
use config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class rolesController extends view

{

    public function index()
    {
        $icon = help::icon();
        $rols = rols::getRols();
        $data["icons"] =  $icon['icons'];
        $data["roles"] =  $rols['data'];
        echo view::renderElement('roles/roles', $data);
    }
    public function getRoles()
    {
        $data['id'] = $_POST['id'];
        echo view::renderElement('roles/rolesTable', $data);
    }
    public function getRolesPermisos()
    {
        $id[':idrol'] = $_POST['id'];
        $data = rols::getRolesPermisos($id);
        $data = $data['data']['permisos'];
        $data = json_decode($data, true);
        $permisos =  $data;
        header('Content-Type: application/json');
        echo json_encode($permisos);
    }

    public function newRol()
    {
        $data = array(
            "rol" => $_POST['rol'],
            "descripcion" => $_POST['descripcion'],
            "creado_por" => (int)$_SESSION["id"],
            "modificado_por" => (int) $_SESSION["id"],

        );

        $rol = rols::setRol($data);

        //admin log

        if ($rol['error'] == '00000') {
            admin::saveLog('Nuevo', 'Permisos', 'Se creo el rol ' . $_POST['rol'], json_encode($datos), $_SESSION["id"]);
        } else {
            admin::saveLog('Error', 'Permisos', 'Error al crear el rol ' . $_POST['rol'], json_encode($datos), $_SESSION["id"]);
        }

        header('Content-Type: application/json');
        echo json_encode($rol);
    }
    public function saveRoles()
    {
        $id = $_POST['id'];
        $permisos = $_POST;
        unset($permisos['id']);
        $jsonString = json_encode($permisos);
        $data = array(
            ":permisos" => $jsonString,
            ":modificado_por" => (int) $_SESSION["id"],
            ":idrol" => (int)$id,
        );
        $rols = rols::setRolpermisos($data);
        $rols['rols'] = $_POST;

        $rolData = rols::getRolById(array(":idrol" => $id));

        if ($rols['error'] == '00000') {
            admin::saveLog('Editar', 'Permisos', 'Se edito el rol ' . $rolData['data']['rol'], json_encode($data), $_SESSION["id"]);
        } else {
            admin::saveLog('Error', 'Permisos', 'Error al editar el rol ' . $rolData['data']['rol'], json_encode($data), $_SESSION["id"]);
        }

        header('Content-Type: application/json');
        echo json_encode($rols);
    }
}
