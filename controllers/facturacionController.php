<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\productModel as product;
use models\usuariosModel as user;
use models\adminModel as admin;
use models\clientesModel as cliente;
use models\facturacionModel as fac;
//Funciones de ayuda
use config\helper as help;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

// la clase debe llamarse igual que el controlador respetando mayusculas
class facturacionController extends view

{

    public function index()
    {

        $info = admin::infoSucursal();
        $info = $info['data'];
        $cliente = cliente::getClienteById(array(":id" => $info['idclienteGenerico']));
        $descuentos = admin::descuentosOnlyFac();
        $icon = help::icon();
        $data["icons"] =  $icon['icons'];
        $data["cliente"] =  $cliente['data'];
        $data["descuentos"] =  $descuentos['data'];
        echo view::renderElement('facturacion/facturacion', $data);
    }
    public function cajas()
    {
        $icon = help::icon();
        $users = user::getUsers();
        $result = fac::getCajas();
        $cajasLastMonth = fac::getLastMonthCajas();
        $data["users"] = $users['data'];
        $data["icons"] =  $icon['icons'];
        $data["cajas"] =  $result['data'];
        $data["cajaslast"] =  $cajasLastMonth['data'];
        echo view::renderElement('cajas/cajas', $data);
    }
    public function historialDiario()
    {
        $icon = help::icon();
        $result = fac::getHistorialDiario();
        $data["icons"] =  $icon['icons'];
        $data["facturas"] =  $result;
        echo view::renderElement('facturacion/historialDiario', $data);
    }
    public function historialDiarioContent()
    {
        $icon = help::icon();
        $start = $_POST['start'];
        $end = $_POST['end'];
        $result = fac::getHistorialDiario($start, $end);
        $data["icons"] =  $icon['icons'];
        $data["facturas"] =  $result;
        echo view::renderElement('facturacion/historialDiarioRows', $data);
    }
    public function lastFactRePrint()
    {
        $icon = help::icon();
        $result = fac::lastFactRePrint();
        $data["icons"] =  $icon['icons'];
        $data["facturas"] =  $result;
        echo view::renderElement('facturacion/lastFactRePrint', $data);
    }
    public function reprintFact()
    {
        $fac = $_POST['fac'];
        $result = fac::getFacToRePrint($fac);
        $header = $result['header']['data'][0];
        $rows = $result['rows']['data'];
        $cantidadArticulos = 0;
        $cantidadArticulos = 0;
        foreach ($rows as $row) {
            $cantidadArticulos += $row['cantidad'];
        }

        $data["items"] =  $rows;
        $data["facturas"] =  $result;
        $Sucursal = admin::infoSucursal()['data'];
        $data["Sucursal"] = $Sucursal;
        $data["nameCliente"] =  $header['cliente'];
        $data["nameVendedor"] =  $header['cajero'];
        $data["monto_envio"] =  $header['monto_envio'] ?? 0;
        $data["tipoVenta"] =  $header['tipo'];
        $data["descuento"] =  $header['descuento'];
        $data["fecha"] =  $header['fecha'];
        $data["subtotal_descuento"] = $header['total'] - $header['monto_envio'] - $header['impuesto'];
        $data["iva"] =  $header['impuesto'];
        $data["total"] =  $header['total'];
        $otherCards = null;
        if ($header['otherCards'] != "") {
            $otherCards = explode(";", $header['otherCards']);
        }
        $methodPay = array("methodPay" => array());
        if ($header['monto_efectivo'] != 0 && $header['monto_efectivo'] != null) {
            $efectivo = array("methods" => array(
                "monto" => $header['monto_efectivo'],
                "montoWithFormat" => number_format($header['monto_efectivo'], '2', '.', ','),
                "tipo" => 'efectivo'
            ));
            array_push($methodPay["methodPay"], $efectivo);
        }
        if ($header['monto_tarjeta'] != 0 && $header['monto_tarjeta'] != null) {
            $efectivo = array("methods" => array(
                "monto" => $header['monto_tarjeta'],
                "montoWithFormat" => number_format($header['monto_tarjeta'], '2', '.', ','),
                "tipo" => 'tarjeta',
                "tarjeta" => $header['numero_tarjeta'],
                "hasMore" => true,
                'extraCards' => array()
            ));
            array_push($methodPay["methodPay"], $efectivo);
        }
        if ($otherCards !== null) {
            foreach ($otherCards as $tarjeta) {
                $card = explode(",", $tarjeta);
                $monto = $card[1];
                $idcard = $card[0];
                $tipo = $card[2];
                $arrayData = array(
                    "monto" => $monto,
                    "montoWithFormat" => number_format($monto, '2', '.', ','),
                    "tipo" => $tipo,
                    "tarjeta" => $idcard,

                );
                array_push($methodPay["methodPay"][1]['methods']['extraCards'], $arrayData);
            }
        }
        if ($header['monto_transferencia'] != 0 && $header['monto_transferencia'] != null) {
            $transferencia = array("methods" => array(
                "monto" => $header['monto_transferencia'],
                "montoWithFormat" => number_format($header['monto_transferencia'], '2', '.', ','),
                "tipo" => 'transferencia',
                "referencia" => $header['referencia_transferencia'],
                "banco" => $header['banco_transferencia']

            ));
            array_push($methodPay["methodPay"], $transferencia);
        }





        $data["cantidadArticulos"] =  $cantidadArticulos;
        $data["methodPay"] =  $methodPay["methodPay"];
        $data["factura"] =  array("fac" => $header['fac']);
        echo view::renderElement('facturas/facturaVentaReprint', $data);
    }
    public function searchFacByNumber()
    {
        $icon = help::icon();
        $fac = (int) $_POST['fac'];

        if ($fac == '' || $fac == null) {
            $this->lastFactRePrint();
            return;
        }
        $result = fac::searchFacByNumber($fac);
        $data["icons"] =  $icon['icons'];
        $data["facturas"] =  $result;
        echo view::renderElement('facturacion/lastFactRePrint', $data);
    }
    public function searchFacByNumberGeneral()
    {
        $icon = help::icon();
        $fac = (int) $_POST['fac'];

        if ($fac == '' || $fac == null) {
            $this->lastFactRePrint();
            return;
        }
        $result = fac::searchFacByNumber($fac);
        $data["icons"] =  $icon['icons'];
        $data["facturas"] =  $result;
        echo view::renderElement('facturacion/facturaReporte', $data);
    }
    public function apartadosSinCancelar()
    {
        $icon = help::icon();
        $result = fac::apartadosSinCancelar();
        $data["icons"] =  $icon['icons'];
        $data["facturas"] =  $result;
        echo view::renderElement('facturacion/apartadosSinCancelar', $data);
    }
    public function pendientes()
    {
        $icon = help::icon();
        $fac = fac::getPendingFac();
        $data["facturas"] = $fac['data'];
        $data["icons"] =  $icon['icons'];
        echo view::renderElement('facturacion/facturas_pendientes', $data);
    }
    public function reprint()
    {
        $icon = help::icon();
        $fac = fac::getPendingFac();
        $data["facturas"] = $fac['data'];
        $data["icons"] =  $icon['icons'];
        echo view::renderElement('facturacion/reprint', $data);
    }

    public function pendientesProductos()
    {
        $id = (int) $_POST['id'];
        $result = fac::pendientesProductos($id);
        $data['productos'] = $result['data'];
        echo view::renderElement('facturacion/tablaProductosPendientes', $data);
    }
    public function changeStateFac()
    {
        $id[':consecutivo'] = (int) $_POST['id'];
        $result = fac::changeStateFac($id);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function devolucion()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = fac::setDevolucion($data);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function saldoDevoluciones()
    {
        $fac = (int) $_POST['fac'];
        $result = fac::saldoDevoluciones($fac);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function abrirCaja()
    {
        $data[':userId'] = (int) $_POST['userId'];
        $data[':monto'] = (float) $_POST['monto'];
        $data[':id'] = (int) $_SESSION['id'];
        $data[':fecha_init'] = $_POST['fecha'];
        $result = fac::setAbrirCaja($data);
        if ($result['error'] == "00000") {
            admin::saveLog('Abrir', 'Caja', 'Se abrio la caja ' . $result['lastID'], json_encode($data), $_SESSION["id"]);
        }else{
            admin::saveLog('Error', 'Caja', 'Error al abrir la caja', json_encode($data), $_SESSION["id"]);
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function abrirCajaEstado()
    {
        $data[':idcaja'] = (int) $_POST['idcaja'];
        $result = fac::abrirCajaEstado($data);
        if ($result['error'] == "00000") {
            admin::saveLog('Abrir', 'Caja', 'Se habilito la caja ' . $_POST['idcaja'], json_encode($data), $_SESSION["id"]);
        }else{
            admin::saveLog('Error', 'Caja', 'Error al abrir la caja ' . $_POST['idcaja'], json_encode($data), $_SESSION["id"]);
        }
        header('Content-Type: application/json');
        $_SESSION['hasCaja'] = true;
        echo json_encode($result);
    }
    public function obtenerEstadoCajaEstado()
    {
        $data[':idcaja'] = (int) $_POST['idcaja'];
        $result = fac::obtenerEstadoCajaEstadoPagos($data);
        //$result = fac::obtenerEstadoCajaEstadoEnvios($data);
        //$result = fac::obtenerEstadoCajaEstadoMonto($data);
        if ($result['error'] == "00000") {
            //$_SESSION['hasCaja'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function updateTotalFacturadoCajas()
    {
        $cajasIdArray = fac::getCajasIDUpdate();
        $cajasId = $cajasIdArray['data'];
        //$cajasId = ['idcaja' => 136];
        $totalCaja = '';
        $result = '';
        $errores = array();
        foreach ($cajasIdArray['data'] as  $id) {
            $data[':idcaja'] =  $id['idcaja'];
            $json = fac::obtenerEstadoCajaEstadoPagos($data);
            $totalCaja = $json['total_general'];
            $result = fac::updateCajasTotal($id['idcaja'], $totalCaja);
            if ($result['error'] != '00000') {
                array_push($errores, $result);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($errores);
    }
    public function cerrarcajafinal()
    {
        $data[':efectivo'] = (float) $_POST['efectivo'];
        $data[':tarjeta'] = (float)  $_POST['tarjeta'];
        $data[':transferencia'] = (float) $_POST['transferencia'];
        $data[':diferencia'] = (float) $_POST['diferencia'];
        $data[':comentario'] = $_POST['comentario'];
        $data[':total_facturado'] = $_POST['total_facturado'];
        $data[':id'] = (int)  $_POST['id'];
        $result = fac::cerrarCajafinal($data);

        if ($result['error'] == "00000") {
            admin::saveLog('Cerrar', 'Caja', 'Se cerro la caja ' . $_POST['id'], json_encode($data), $_SESSION["id"]);
        }else{
            admin::saveLog('Error', 'Caja', 'Error al cerrar la caja ' . $_POST['id'], json_encode($data), $_SESSION["id"]);
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
    public function consultarFactura()
    {
        $data = fac::getFacturaForDevolution(trim($_POST['fac']));
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function getFact()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->setFacHeader($data);
        $data["data"] = admin::infoSucursal();
        $data["factura"] =  ($result[1]['data']['fac'] > 0 ? $result[1]['data'] : "error");
        // die();
        if ($result[0] == 0) {
            if ($data['sendFac']) {
                echo view::renderElement('facturas/facturaVenta', $data);
            }
        } else if ($result[0] == 1) {
            $data['idrecibo'] = $result[2]['idrecibo'];
            echo view::renderElement('facturas/reciboApartado', $data);
        }
    }
    public function setFacHeader($datos)
    {
        if (isset($_SESSION['hasCaja']) &&  $_SESSION['hasCaja'] == true) {

            //efectivo
            $data[':efectivo'] = 0;
            $data[':monto_efectivo'] = (float) 0.00;
            //tarjeta
            $data[':tarjeta'] = 0;
            $data[':numero_tarjeta'] = null;
            $data[':monto_tarjeta'] = (float) 0.00;
            $data[':multipago_string'] = ''; //string de tarjetas
            $data[':multipago'] = 0;
            $data[':multipago_total'] = (float) 0.00;
            //transferencia
            $data[':transferencia'] = 0;
            $data[':banco_transferencia'] = "";
            $data[':referencia_transferencia'] = "";
            $data[':monto_transferencia'] = (float)  0.00;
            //demas datos
            $data[':monto_envio'] = (float)  ($datos['monto_envio'] > 0 ? $datos['monto_envio'] : 0);
            $data[':idusuario'] = (int) $_SESSION['id'];
            $data[':idcliente'] = (int) $datos['idCliente'];
            $data[':impuesto'] = (float) str_replace(",", "", $datos['iva']);
            $data[':descuento'] = (float) str_replace(",", "", $datos['descuento']);
            $data[':total'] = (float) str_replace(",", "", $datos['total']);
            $data[':tipo'] = (int) $datos['tipoVenta'];
            $data[':estado'] = (int) $datos['estado'];
            $data[':comentario'] = 'Sin comentarios';
            $data[':saldo'] = $datos['hasSaldo'] == true ? (float) $datos['saldo'] : 0;
            $data[':saldo_ref'] = $datos['hasSaldo'] == true ? (float) $datos['saldo_ref'] : 0;
            $data[':new_saldo'] = $datos['hasSaldo'] == true ? (float) $datos['new_saldo'] : '';
            $data[':hasSaldo'] = $datos['hasSaldo'];
            $data[':idcaja'] = $_SESSION['idcaja'];

            //verificamos si la factura lleva un pago
            if ($datos['hasPay']) {
                foreach ($datos['methodPay'] as $metodo) {
                    if ($metodo['methods']['tipo'] == "efectivo") {
                        $data[':efectivo'] = 1;
                        $data[':monto_efectivo'] = (float) $metodo['methods']['monto'];
                    } else if ($metodo['methods']['tipo'] == "tarjeta") {
                        $data[':tarjeta'] = 1;
                        $data[':numero_tarjeta'] = (int) $metodo['methods']['tarjeta'];
                        $data[':monto_tarjeta'] = (float) $metodo['methods']['monto'];
                        if ($metodo['methods']['hasMore']) {
                            $data[':multipago_total'] =  $metodo['methods']['totalExtraCards'];
                            $data[':multipago'] = 1;

                            foreach ($metodo['methods']['extraCards'] as $cards) { //extraCards
                                $data[':multipago_string'] .= $cards['tarjeta'] . ',' . $cards['monto'] . ',' . $cards['tipo'] . ';';
                            }
                            $data[':multipago_string'] = rtrim($data[':multipago_string'], ';');
                        }
                    } else if ($metodo['methods']['tipo'] == "transferencia") {
                        $data[':transferencia'] = 1;
                        $data[':banco_transferencia'] = $metodo['methods']['banco'];
                        $data[':referencia_transferencia'] = $metodo['methods']['referencia'];
                        $data[':monto_transferencia'] = (float)  $metodo['methods']['monto'];
                    }
                }
            }

            if ($datos['tipoVenta'] == 3 && $datos['firstAbono'] == 1) {
                //efectivo
                $data[':efectivo'] = 0;
                $data[':monto_efectivo'] = (float) 0.00;
                //tarjeta
                $data[':tarjeta'] = 0;
                $data[':numero_tarjeta'] = null;
                $data[':monto_tarjeta'] = (float) 0.00;
                $data[':multipago_string'] = ''; //string de tarjetas
                $data[':multipago'] = 0;
                $data[':multipago_total'] = (float) 0.00;
                //transferencia
                $data[':transferencia'] = 0;
                $data[':banco_transferencia'] = "";
                $data[':referencia_transferencia'] = "";
                $data[':monto_transferencia'] = (float)  0.00;
                $fac = fac::setFacHeader($data, $datos);
                foreach ($datos['methodPay'] as $metodo) {
                    if ($metodo['methods']['tipo'] == "efectivo") {
                        $data[':efectivo'] = 1;
                        $data[':monto_efectivo'] = (float) $metodo['methods']['monto'];
                    } else if ($metodo['methods']['tipo'] == "tarjeta") {
                        $data[':tarjeta'] = 1;
                        $data[':numero_tarjeta'] = (int) $metodo['methods']['tarjeta'];
                        $data[':monto_tarjeta'] = (float) $metodo['methods']['monto'];
                        if ($metodo['methods']['hasMore']) {
                            $data[':multipago_total'] =  $metodo['methods']['totalExtraCards'];
                            $data[':multipago'] = 1;

                            foreach ($metodo['methods']['extraCards'] as $cards) { //extraCards
                                $data[':multipago_string'] .= $cards['tarjeta'] . ',' . $cards['monto'] . ',' . $cards['tipo'] . ';';
                            }
                            $data[':multipago_string'] = rtrim($data[':multipago_string'], ';');
                        }
                    } else if ($metodo['methods']['tipo'] == "transferencia") {
                        $data[':transferencia'] = 1;
                        $data[':banco_transferencia'] = $metodo['methods']['banco'];
                        $data[':referencia_transferencia'] = $metodo['methods']['referencia'];
                        $data[':monto_transferencia'] = (float)  $metodo['methods']['monto'];
                    }
                }
                $data[':abono'] = (float) ($data[':monto_efectivo'] + $data[':monto_transferencia'] + $data[':monto_tarjeta'] + $data[':multipago_total']);
                $data[':idfactura'] = (int) $fac['data']['fac'];
                $abono = fac::setAbonoRecibo($data, false); //False para que elimine los campos extras y true porque ya no los lleva el array
                $abono['fac'] = (int) $fac['data']['fac'];
                return array(1, $fac, $abono);
            } else {
                $fac = fac::setFacHeader($data, $datos);
                return array(0, $fac);
            }
        }
        return array(["error" => "FAC0001", "errorMsg" => "No existe una caja abierta para el usuario"]);
    }
    public function getApartadosHasClient()
    {
        $apartados =  fac::getApartadosHasClient($_POST['cliente']);
        header('Content-Type: application/json');
        echo json_encode($apartados);
    }
    public function getProductsFromApartado()
    {
        $apartados =  fac::getProductsFromApartado($_POST['fac']);
        header('Content-Type: application/json');
        echo json_encode($apartados);
    }
    public function setAbono()
    {
        $cards = rtrim($_POST['cards'], ';');
        $totalCards = (float) $_POST['totalCards'];
        $cards = explode(";", $cards);


        $montoEfectivo = str_replace(",", "", ($_POST['efectivoMontoAbono']));
        $montoTarjeta = str_replace(",", "", $_POST['tarjetaMontoAbono']);
        $montoTransferencia = str_replace(",", "", $_POST['bancoMontoAbono']);
        $montoEfectivo = (float) $montoEfectivo;
        $montoTarjeta = (float) $montoTarjeta;
        $montoTransferencia = (float) $montoTransferencia;

        $montoEfectivo = (float)($montoEfectivo > 0 ? $montoEfectivo : 0.00);
        $montoTarjeta = (float)($montoTarjeta > 0 ? $montoTarjeta : 0.00);
        $montoTransferencia = (float)($montoTransferencia > 0 ? $montoTransferencia : 0.00);

        $data[':idfactura'] = (int)$_POST['idfactura'];
        $data[':abono'] = (float)($montoEfectivo + $montoTarjeta + $montoTransferencia);
        //efectivo
        $data[':efectivo'] = (int)($montoEfectivo > 0 ? 1 : 0);
        $data[':monto_efectivo'] = (float)($montoEfectivo > 0 ? $montoEfectivo : 0.00);
        //tarjeta
        $data[':tarjeta'] = (int)($montoTarjeta > 0 ? 1 : 0);
        $data[':numero_tarjeta'] = (int)($montoTarjeta > 0 ? $_POST['tarjetaAbono'] : null);
        $data[':monto_tarjeta'] = (float)($montoTarjeta > 0 ? $montoTarjeta : 0.00);
        if ($totalCards > 0) {
            $data[':multipago_total'] = (float) $totalCards;
            $data[':multipago_string'] = rtrim($_POST['cards'], ';');
            $data[':multipago'] = 1;
            $data[':abono'] = (float)($data[':abono'] + $totalCards);
        } else {
            $data[':multipago'] = 0;
            $data[':multipago_total'] = (float) 0.00;
            $data[':multipago_string'] = null;
        }
        //transferencia
        $data[':transferencia'] = (int)($montoTransferencia > 0 ? 1 : 0);
        $data[':banco_transferencia'] = ($_POST['banco'] !== "" ? $_POST['banco'] : "");
        $data[':referencia_transferencia'] = ($_POST['referenciaAbono'] !== "" ? $_POST['referenciaAbono'] : "");
        $data[':monto_transferencia'] = (float)($montoTransferencia > 0 ? $montoTransferencia : 0.00);
        //demas datos
        $data[':idusuario'] = (int)$_SESSION['id'];
        $NewData['methods'] = [];


        $saldo = fac::getApartadoSaldoHasClientByFac((int)$_POST['idfactura']);
        if ($saldo['rows'] == 1) {
            $saldoTotal = (float) str_replace(",", "", $saldo['data'][0]['saldo']);
            $abono = (float)$data[':abono'];
            if ((float)$abono > (float)$saldoTotal) {
                header('Content-Type: application/json');
                echo json_encode(['error' => true, 'msg' => "El monto abonado excede el monto en saldo (Abono: $abono ,Saldo: $saldoTotal)"]);
                exit;
            }
        }



        $apartados =  fac::setAbonoRecibo($data, true);

        if ($apartados['error'] == '00000') {
            admin::saveLog('Abono', 'Apartados', 'Se abono a la factura ' . $_POST['idfactura'], json_encode($data), $_SESSION["id"]);
        } else {
            admin::saveLog('Error', 'Apartados', 'Error al abonar a la factura ' . $_POST['idfactura'], json_encode($data), $_SESSION["id"]);
        }


        $NewData["data"] = admin::infoSucursal();
        if ($montoEfectivo > 0) {
            $efectivoArray = ["tipo" => "efectivo", "monto" => $montoEfectivo];
            array_push($NewData['methods'], $efectivoArray);
        }
        if ($montoTarjeta > 0) {
            $tarjetaArray = ["tipo" => "tarjeta", "tarjeta" => $_POST['tarjetaAbono'], "monto" => $montoTarjeta];
            array_push($NewData['methods'], $tarjetaArray);
        }
        if ($montoTransferencia > 0) {
            $transferencia = ["tipo" => "transferencia", "monto" =>  $montoTransferencia];
            array_push($NewData['methods'], $transferencia);
        }



        $NewData["factura"] =  $data[':idfactura'];
        $NewData["nameCliente"] =  $_POST['cliente'];
        $NewData["nameVendedor"] =  $_POST['vendedor'];
        $NewData["abono"] =  $data[':abono'];
        $NewData["idrecibo"] = $apartados['idrecibo'];
        $NewData["AbonoTotal"] = $apartados['AbonoTotal'];
        $NewData["fecha_final"] = $apartados['fecha_final'];
        $NewData["total"] = $apartados['total'];
        $NewData['idrecibo'] = $apartados['idrecibo'];
        $NewData['cards'] = $cards;
        echo view::renderElement('facturas/reciboSinproducto', $NewData);
    }
}
