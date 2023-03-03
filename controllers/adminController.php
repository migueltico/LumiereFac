<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\adminModel as admin;
//Funciones de ayuda
use config\helper as help;
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
    public function general($var)
    {
        $general = admin::getGeneralInfo();
        $icon = help::icon();
        $data = $general['data']; // se pone de primero para que las variables se creen en el primer nivel
        $data["icons"] =  $icon['icons']; //las segundas se agregan despues para evitar ser borradas
        view::renderElement('general/general', $data);
    }
    public function SaveGeneralInfo($var)
    {
        $general = admin::addGeneralInfo($_POST);
        //$array = array($_POST,$general);
        header('Content-Type: application/json');
        echo json_encode($general);
    }
    public function addnewDescuento($var)
    {
        $show = (isset($_POST['show']) ? 1 : 0);
        $data[':show'] = (int) $show;
        $data[':descripcion'] = $_POST['descripcion'];
        $data[':descuento'] = (int) $_POST['descuento'];
        $data[':creado_por'] = (int) $_SESSION['id'];
        $data[':modificado_por'] = (int) $_SESSION['id'];
        $data[':activo'] = 1;
        $admin = admin::addnewDescuento($data);
        header('Content-Type: application/json');
        echo json_encode($admin);
    }
    public function EditarDescuento($var)
    {
        $check = (isset($_POST['activo']) ? 1 : 0);
        $show = (isset($_POST['show']) ? 1 : 0);
        $data[':show'] = (int) $show;
        $data[':descripcion'] = $_POST['descripcion'];
        $data[':descuento'] = (float) $_POST['descuento'];
        $data[':modificado_por'] = (int) $_SESSION['id'];
        $data[':activo'] = (int)  $check;
        $data[':id'] = (int) $_POST['id'];
        $admin = admin::updateDescuento($data);
        header('Content-Type: application/json');
        echo json_encode($admin);
    }
    public function aplicarDescuentoEnLote($var)
    {
        $data[':codigos'] = $_POST['codigos'];
        $data[':iddescuento'] = $_POST['iddescuento'];
        $admin = admin::aplicarDescuentoEnLote($data);
        header('Content-Type: application/json');
        echo json_encode($admin);
    }

    public function descuentos($var)
    {
        $descuentos = admin::descuentos();
        $icon = help::icon();
        $data['data'] = $descuentos['data']; // se pone de primero para que las variables se creen en el primer nivel
        $data["icons"] =  $icon['icons']; //las segundas se agregan despues para evitar ser borradas
        view::renderElement('descuentos/descuentos', $data);
    }
    public function ofertas($var)
    {
        $ofertas = admin::getAllOfertas();
        $icon = help::icon();
        $data['data'] = $ofertas['data']; // se pone de primero para que las variables se creen en el primer nivel
        $data["icons"] =  $icon['icons']; //las segundas se agregan despues para evitar ser borradas
        view::renderElement('ofertas/ofertas', $data);
    }
    //para el search
    public function getproduct($var)
    {
        $codigo = $_POST['codigo'];
        $trasladoSearch = isset($_POST['traslado']) ?? false;

        if ($this->verificarProductoDuplicadoOferta($codigo)) {
            echo 'duplicado';
            return;
        }

        $productos = admin::getproduct($codigo);
        $icon = help::icon();
        $data['data'] = $productos['data']; // se pone de primero para que las variables se creen en el primer nivel
        $data["icons"] =  $icon['icons']; //las segundas se agregan despues para evitar ser borradas
        if ($productos['rows'] == 1) {
            if ($trasladoSearch) {
                view::renderElement('inventario/tableTrasladoSearch.php', $data);
            } else {
                view::renderElement('ofertas/articuloModal', $data);
            }
        } else {
            echo '0';
        }
    }

    public function verificarProductoDuplicadoOferta($codigo)
    {
        $ofertas = admin::getAllOfertas();

        foreach ($ofertas['data'] as $oferta) {
            $ids = explode(',', $oferta['productos']);
            foreach ($ids as $id) {
                if ($id == $codigo) {
                    return true;
                }
            }
        }
        return false;
    }

    //para el edit
    public function getproductReturn($id)
    {
        $codigo = $id;
        $productos = admin::getproduct($codigo);
        $icon = help::icon();
        $data['data'] = $productos['data']; // se pone de primero para que las variables se creen en el primer nivel
        $data["icons"] =  $icon['icons']; //las segundas se agregan despues para evitar ser borradas
        if ($productos['rows'] == 1) {

            $html = view::renderElementReturn('ofertas/articuloModal', $data);
            return $html;
        } else {
            return '';
        }
    }
    public function addoferta($var)
    {
        $data = array(
            ":nombreOferta" => $_POST['nombreOferta'],
            ":cantidad" => $_POST['cantidad'],
            ":productoOrlista" => $_POST['productoOrlista'],
            ":descuento" => $_POST['descuento'],
            ":unica" => isset($_POST['unica']) ? 1 : 0,
            ":productos" => $_POST['productos']
        );
        $productos = admin::addoferta($data);
        $productosUpdateOfertaID = $productos;
        if ($productos['id'] > 0) {
            $id = $productos['id'];
            $listProducts = explode(',', $_POST['productos']);
            $productosUpdateOfertaID = admin::updateOfertaID($id, $listProducts);
        } else {
            $productosUpdateOfertaID = ['error' => 'error al crear la oferta', 'Data' => $productos];
        }
        header('Content-Type: application/json');
        echo json_encode($productosUpdateOfertaID);
    }
    public function updateOferta($var)
    {
        $data = array(
            ":id" => $_POST['idOferta'],
            ":nombreOferta" => $_POST['nombreOferta'],
            ":cantidad" => $_POST['cantidad'],
            ":productoOrlista" => $_POST['productoOrlista'],
            ":descuento" => $_POST['descuento'],
            ":unica" => isset($_POST['unica']) ? 1 : 0,
            ":productos" => $_POST['productos']
        );
        $productos = admin::updateOferta($data);
        header('Content-Type: application/json');
        echo json_encode($productos);
    }
    public function deleteOferta($var)
    {
        $id = $_POST['idOferta'];
        $ofertas = admin::deleteOferta($id);
        header('Content-Type: application/json');
        echo json_encode($ofertas);
    }
    public function getOfertasById($var)
    {
        $id = $_POST['idOferta'];
        $ofertas = admin::getOfertasById($id);
        $htmlRows = '';
        if ($ofertas['rows'] > 0) {
            $ids = explode(',', $ofertas['data']['productos']);

            foreach ($ids as $id) {
                $htmlRows .= $this->getproductReturn($id);
            }
        }
        $ofertas['htmlRows'] = $htmlRows;
        header('Content-Type: application/json');
        echo json_encode($ofertas);
    }

    public function descuentosPorLote($var)
    {
        $descuentos = admin::descuentos();
        $icon = help::icon();
        $data['data'] = $descuentos['data']; // se pone de primero para que las variables se creen en el primer nivel
        $data["icons"] =  $icon['icons']; //las segundas se agregan despues para evitar ser borradas
        view::renderElement('descuentos/descuentosPorLote', $data);
    }
    public function indexCategoriasTallas($var)
    {
        $getTallas = admin::getTallas();
        $getCategorias = admin::getCategorias();
        $icon = help::icon();
        $data["icons"] =  $icon['icons'];
        $data['categorias'] = $getCategorias['data'];
        $data['tallas'] = $getTallas['data'];
        view::renderElement('categoriasTallas/categoriasTallas', $data);
    }
    public function tableCategoriaPrecios($var)
    {
        $cat_precios = admin::getCategoriaPrecios();
        $icon = help::icon();
        $data["icons"] =  $icon['icons'];
        $data['categorias_precios'] = $cat_precios['data'];
        view::renderElement('categoriaPrecios/categoriaPreciosTable', $data);
    }
    public function tableCategoriaTallas($var)
    {
        $getTallas = admin::getTallas();
        $getCategorias = admin::getCategorias();
        $icon = help::icon();
        $data["icons"] =  $icon['icons'];
        $data['categorias'] = $getCategorias['data'];
        $data['tallas'] = $getTallas['data'];
        view::renderElement('categoriasTallas/categoriasTallas', $data);
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
    public function editCategorias()
    {
        $data[':categoria'] = $_POST['categoria'];
        $data[':id'] = $_POST['id'];
        $result = admin::editCategorias($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function editTallas()
    {
        $data[':id'] = $_POST['id'];
        $data[':descripcion'] = $_POST['descripcion'];
        $data[':talla'] = $_POST['talla'];
        $result = admin::editTallas($data);
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
    public function AddCategoria()
    {
        $data[':categoria'] = $_POST['categoria'];
        $result = admin::AddCategoria($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function AddTalla()
    {
        $data[':descripcion'] = $_POST['descripcion'];
        $data[':talla'] = $_POST['talla'];
        $result = admin::AddTalla($data);
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
    public function makeBackupDB()
    {
        $result = admin::makeBackupDB();
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
