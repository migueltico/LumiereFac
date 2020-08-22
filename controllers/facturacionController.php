<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\sucursalModel as sucursal;
use models\adminModel as admin;
use controllers\uploadsController as upload;
//Funciones de ayuda
use Config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class facturacionController extends view

{

    public function index($var)
    {
        // $icon = help::icon();
        // $categorias = product::getCategory();
        // $cat_precios = admin::getCategoriaPrecios();
        // //$categorias = product::getCategory();
        // $tallas = product::getTallas();
        // $products = product::getProducts();
        // $data["categorias"] = $categorias['data'];
        // $data["tallas"] = $tallas['data'];
        // $data["products"] = $products['data'];
        // $data["cat_precios"] = $cat_precios['data'];
        // $data["icons"] =  $icon['icons'];
        echo view::renderElement('facturacion/facturacion');
    }
    public function addstock($var)
    {
        //$icon = help::icon();
        //$products = product::searchProduct('');
        //$data["products"] = $products['data'];
        //$data["icons"] =  $icon['icons'];
        //echo view::renderElement('inventario/productosTableStock', $data);
        //echo view::renderElement('inventario/addstock', $data);
    }
    public function searchProduct($var)
    {

        $product = product::searchCodeProduct($_POST['toSearch']);
        header('Content-Type: application/json');
        echo json_encode($product);
    }
    public function searchProductCtrlQ($var)
    {
        $product = product::searchCodeProductCtrlQ($_POST['toSearch'], $_POST['initLimit']);
        header('Content-Type: application/json');
        echo json_encode($product);
    }
}
