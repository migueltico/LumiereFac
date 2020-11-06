<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\usuariosModel as user;
use models\adminModel as admin;
use models\facturacionModel as fac;
use Dompdf\Dompdf;
use Dompdf\Options;
//Funciones de ayuda
use config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class facturacionController extends view

{

    public function index()
    {
        echo view::renderElement('facturacion/facturacion');
    }
    public function cajas()
    {
        $icon = help::icon();
        $users = user::getUsers();
        $result = fac::getCajas();
        $data["users"] = $users['data'];
        $data["icons"] =  $icon['icons'];
        $data["cajas"] =  $result['data'];
        echo view::renderElement('cajas/cajas', $data);
    }
    public function pendientes()
    {
        $icon = help::icon();
        $fac = fac::getPendingFac();
        $data["facturas"] = $fac['data'];
        $data["icons"] =  $icon['icons'];
        echo view::renderElement('facturacion/facturas_pendientes', $data);
    }

    public function abrirCaja()
    {
        $data[':userId'] = (int) $_POST['userId'];
        $data[':monto'] = (float) $_POST['monto'];
        $data[':id'] = (int) $_SESSION['id'];
        $data[':fecha_init'] = $_POST['fecha'];
        $result = fac::setAbrirCaja($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function abrirCajaEstado()
    {
        $data[':idcaja'] = (int) $_POST['idcaja'];
        $result = fac::abrirCajaEstado($data);
        if ($result['error'] == "00000") {
            $_SESSION['idcaja'] = (int) $_POST['idcaja'];
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function cerrarCajaEstado()
    {
        $data[':idcaja'] = (int) $_POST['idcaja'];
        $result = fac::abrirCajaEstado($data);
        if ($result['error'] == "00000") {
            $_SESSION['idcaja'] = (int) $_POST['idcaja'];
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function searchProduct()
    {

        $product = product::searchCodeProduct($_POST['toSearch']);
        header('Content-Type: application/json');
        echo json_encode($product);
    }

    public function searchProductCtrlQ()
    {
        $product = product::searchCodeProductCtrlQ($_POST['toSearch'], $_POST['initLimit']);
        header('Content-Type: application/json');
        echo json_encode($product);
    }
    public function getFact()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->setFacHeader($data);
        if ($result[0] == 0) {

            $data["data"] = admin::infoSucursal();
            $data["factura"] =  ($result[1]['rows'] == 1 ? $result[1]['data'] : "error");

            if ($data['sendFac']) {
                echo view::renderElement('facturas/facturaVenta', $data);
            }
        } else if ($result[0] == 1) {
            echo view::renderElement('facturas/reciboApartado', $data);
        } else if ($result[0] == 2 || ($result[1]['rows'] == 1 ? true : false)) {
            echo view::renderElement('facturas/reciboApartado', $data);
        }
    }
    public function setFacHeader($datos)
    {
        if (isset($_SESSION['idcaja']) && $_SESSION['idcaja'] !== "") {

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
            $data[':idcaja'] = $_SESSION['idcaja'];
            //verificamos si la factura lleva un pago
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
            //Si la factura es del tipo Apartado inicial, se pone en cero los montos
            if ($datos['tipoVenta'] == 3 && $datos['firstAbono']) {
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

                $fac = fac::setFacHeader($data, $datos);
                $abono = fac::setAbonoRecibo($data, $datos);
                return array(2, $fac, $abono);
            } else if ($datos['tipoVenta'] == 3 && $datos['abono']) {
                $abono = fac::setAbonoRecibo($data, $datos);
                return array(1, $abono);
            } else {
                $fac = fac::setFacHeader($data, $datos);
                return array(0, $fac);
            }
        }
        return array(["error" => "FAC0001", "errorMsg" => "No existe una caja abierta para el usuario"]);
    }
}
