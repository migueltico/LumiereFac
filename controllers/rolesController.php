<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\rolesModel as rols;
use Dompdf\Dompdf;
use Dompdf\Options;
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
        header('Content-Type: application/json');
        echo json_encode($rols);
    }
}
