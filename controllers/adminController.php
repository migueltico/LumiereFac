<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\adminModel as admin;
//Funciones de ayuda
use Config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class adminController extends view

{

    public function indexGastos($var)
    {
        $gastos = admin::getGastos();
        $data = $gastos['data'];
        view::renderElement('gastos/gastos', $data);
    }
    public function indexCategoriaPrecios($var)
    {
        $cat_precios = admin::getCategoriaPrecios();
        $icon = help::icon();
        $data["icons"] =  $icon['icons'];
        $data['categorias_precios'] = $cat_precios['data'];
        view::renderElement('categoriaPrecios/categoriaPrecios', $data);
    }
    public function tableCategoriaPrecios($var)
    {
        $cat_precios = admin::getCategoriaPrecios();
        $icon = help::icon();
        $data["icons"] =  $icon['icons'];
        $data['categorias_precios'] = $cat_precios['data'];
        view::renderElement('categoriaPrecios/categoriaPreciosTable', $data);
    }
    public function saveGastos()
    {
        $total = (float) 0.00;
        $gastos = explode(",", $_POST['gastos']);
        foreach ($gastos as $key => $value) {
            $value = explode(":", $value);
            $total = (float) $total + (float) $value[1];
        }
        $data[':gastos'] = $_POST['gastos'];
        $data[':total'] = $total;
        $data[':iduser'] = $_SESSION['id'];
        $result = admin::setGastos($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function AddCategoriaPrecios()
    {

        $data[':descripcion'] = $_POST['descripcion'];
        $data[':factor'] = $_POST['factor'];
        $data[':iduser'] = $_SESSION['id'];
        $result = admin::AddCategoriaPrecios($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function EditCategoriaPrecios()
    {
        $data[':id'] = $_POST['id'];
        $data[':descripcion'] = $_POST['descripcion'];
        $data[':factor'] = $_POST['factor'];
        $data[':iduser'] = $_SESSION['id'];
        $result = admin::EditCategoriaPrecios($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function DeleteCategoriaPrecios()
    {
        $data[':id'] = $_POST['id'];
        $result = admin::DeleteCategoriaPrecios($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
