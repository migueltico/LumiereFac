<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\sucursalModel as sucursal;
use models\adminModel as admin;
use models\facturacionModel as fac;
use Dompdf\Dompdf;
use Dompdf\Options;
//Funciones de ayuda
use config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class facturacionController extends view

{

    public function index($var)
    {
        echo view::renderElement('facturacion/facturacion');
    }
    public function pendientes($var)
    {
        $icon = help::icon();
        $fac = fac::getPendingFac();
        $data["facturas"] = $fac['data'];
        $data["icons"] =  $icon['icons'];
        echo view::renderElement('facturacion/facturas_pendientes', $data);
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
    public function getFact()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->setFacHeader($data);
        $data["data"] = admin::infoSucursal();
        $data["factura"] =  ($result['rows'] == 1 ? $result['data'] : "error");

        if ($data['sendFac']) {
            echo view::renderElement('facturas/facturaVenta', $data);
        }
    }
    public function setFacHeader($datos)
    {
        //efectivo
        $data[':efectivo'] = 0;
        $data[':monto_efectivo'] = (float) 0.00;
        //tarjeta
        $data[':tarjeta'] = 0;
        $data[':numero_tarjeta'] = (float) 0.00;
        $data[':monto_tarjeta'] = (float) 0.00;
        //transferencia
        $data[':transferencia'] = 0;
        $data[':banco_transferencia'] = "";
        $data[':referencia_transferencia'] = "";
        $data[':monto_transferencia'] = (float)  0.00;
        //demas datos
        $data[':idusuario'] = (int) $_SESSION['id'];
        $data[':idcliente'] = (int) $datos['idCliente'];
        $data[':impuesto'] = (float) str_replace(",", "", $datos['iva']);
        $data[':descuento'] = (float) str_replace(",", "", $datos['descuento']);
        $data[':total'] = (float) str_replace(",", "", $datos['total']);
        $data[':tipo'] = (int) $datos['tipoVenta'];
        $data[':estado'] = (int) $datos['estado'];
        $data[':comentario'] = 'Sin comentarios';
        if ($datos['hasPay'] == 1) {
            foreach ($datos['methodPay'] as $metodo) {
                if ($metodo['methods']['tipo'] == "efectivo") {
                    $data[':efectivo'] = 1;
                    $data[':monto_efectivo'] = (float) $metodo['methods']['monto'];
                } else if ($metodo['methods']['tipo'] == "tarjeta") {
                    $data[':tarjeta'] = 1;
                    $data[':numero_tarjeta'] = (int) $metodo['methods']['tarjeta'];
                    $data[':monto_tarjeta'] = (float) $metodo['methods']['monto'];
                } else if ($metodo['methods']['tipo'] == "transferencia") {
                    $data[':transferencia'] = 1;
                    $data[':banco_transferencia'] = $metodo['methods']['banco'];
                    $data[':referencia_transferencia'] = $metodo['methods']['referencia'];
                    $data[':monto_transferencia'] = (float)  $metodo['methods']['monto'];
                }
            }
        }
        //   :idfactura, :idproducto, :cantidad, :precio, :descuento, :iva, :total



        $fac = fac::setFacHeader($data, $datos);
        return $fac;
    }
}
