<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\sucursalModel as sucursal;
use models\adminModel as admin;
use models\clientesModel as cliente;
use controllers\uploadsController as upload;
//Funciones de ayuda
use config\helper as help;
use Dompdf\Dompdf;
use Dompdf\Options;

class clientesController extends view

{

    public function index()
    {
        $icon = help::icon();
        $clientes = cliente::getClientes();
        $data["icons"] =  $icon['icons'];
        $data["clientes"] =  $clientes['data'];
        echo view::renderElement('clientes/clientes', $data);
    }
    public function getClienteById()
    {
        $data[":id"] = $_POST['id'];
        $clientes = cliente::getClienteById($data);
        header('Content-Type: application/json');
        echo json_encode($clientes);
    }
    public function addNewClient()
    {
        $datos[':nombre'] = $_POST['nombre'];
        $datos[':cedula'] = $_POST['cedula'];
        $datos[':telefono'] = $_POST['tel'];
        $datos[':email'] = $_POST['email'];
        $datos[':direccion'] = $_POST['direccion2'] == '' ? $_POST['direccion'] : $_POST['direccion'] . ';' . $_POST['direccion2'];
        $datos[':id'] = $_SESSION['id'];
        if($datos[":nombre"] !==""){
            $clientes = cliente::addNewClient($datos);
            header('Content-Type: application/json');
            echo json_encode($clientes);
        }else{
            echo json_encode(help::errorMsg("CLIENTE00002","El cliente debe llevar almenos un nombre",));
        }
    }
    public function updateClienteById()
    {
        $datos[':nombre'] = $_POST['nombre'];
        $datos[':cedula'] = $_POST['cedula'];
        $datos[':telefono'] = $_POST['tel'];
        $datos[':email'] = $_POST['email'];
        $datos[':direccion'] = $_POST['direccion2'] == '' ? $_POST['direccion'] : $_POST['direccion'] . ';' . $_POST['direccion2'];
        $datos[':id'] = $_SESSION['id'];
        $datos[':idcliente'] = $_POST['idcliente'];
        $clientes = cliente::updateClienteById($datos);
        header('Content-Type: application/json');
        echo json_encode($clientes);
    }
    public function refreshClients()
    {
        $icon = help::icon();
        $clientes = cliente::getClientes();
        $data["icons"] =  $icon['icons'];
        $data["clientes"] =  $clientes['data'];
        echo view::renderElement('clientes/clientesTable', $data);
    }
    public function searchClient()
    {
        $clientes = cliente::searchClient($_POST['toSearch'], $_POST['initLimit']);
        header('Content-Type: application/json');
        echo json_encode($clientes);
    }
}
