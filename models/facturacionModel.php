<?php

namespace models;

use config\helper as h;
use config\conexion;
use DateTime;
use models\adminModel as admin;

class facturacionModel
{
    /**
     * Obtiene el usuario que coincida con los datos proporcionados
     *
     * @param string $user
     * @param string $pass
     * @return void
     */
    public static function setFacHeader($data, $items)
    {

        $con = new conexion();
        $conse = $con->SQR_ONEROW("SELECT * FROM consecutivos WHERE idconsecutivos = 1");
        $consecutivo = ((int) $conse['data']['fac']) + 1;
        $data[':consecutivo'] = $consecutivo;
        $newSaldo = $data[':new_saldo'];
        $hasSaldo = $data[':hasSaldo'];
        $saldo_ref = $data[':saldo_ref']; //no borrar
        $saldo = $data[':saldo']; //no borrar
        $idusuario = $data[':idusuario']; //no borrar
        unset($data[':new_saldo']);
        unset($data[':hasSaldo']);
        $data[':formatDate'] = date("Y-m-d");
        $headerSql = "
        INSERT INTO facturas 
        (consecutivo,idcaja,idusuario,idcliente,impuesto,descuento,total,tipo,efectivo,tarjeta,transferencia,banco_transferencia,
        referencia_transferencia,monto_transferencia,numero_tarjeta,monto_tarjeta,monto_efectivo,monto_envio,estado,comentario,multipago_String,multipago,multipago_total,formatDate, saldo, saldo_ref) 
        VALUE (:consecutivo, :idcaja, :idusuario, :idcliente, :impuesto, :descuento, :total, :tipo, :efectivo, :tarjeta, :transferencia, :banco_transferencia, :referencia_transferencia, :monto_transferencia, :numero_tarjeta, 
        :monto_tarjeta, :monto_efectivo, :monto_envio, :estado, :comentario, :multipago_string, :multipago, :multipago_total, :formatDate, :saldo, :saldo_ref);";
        $result = $con->SQ($headerSql, $data);

        if ($result['error'] == '00000') {
            $insert = $con->SQ("UPDATE consecutivos SET fac = :consecutivo", array(':consecutivo' => (int) $consecutivo));
            if ($hasSaldo) {
                $con1 = new conexion();
                $sqlTransaccion = "INSERT INTO transacciones_saldos (fac, ref, saldoUsado, saldoPendiente, idusuario) VALUE ($consecutivo, $saldo_ref, $saldo, $newSaldo, $idusuario) ";
                $transaccion = $con1->SQNDNR($sqlTransaccion);
                if ($transaccion['error'] == '00000') {
                    $newDetalles = $con->SQNDNR("UPDATE devoluciones SET  Saldo = $newSaldo WHERE fac =$saldo_ref");
                }
            }
            $con2 = new conexion();
            //$result2 = $con2->SQR_ONEROW('SELECT * FROM consecutivos WHERE idconsecutivos = 1');
            $itemsSql = [];

            foreach ($items['items'] as $item) {
                array_push($itemsSql, array(
                    ":idfactura" => $consecutivo,
                    ":idproducto" => (int) $item['id'],
                    ":cantidad" => (int) $item['cantidad'],
                    ":precio" => (float) str_replace(",", "", $item['precio']),
                    ":descuento" => (int) (rtrim($item['descuento'], "%")),
                    ":iva" => (int) $item['iva'],
                    ":total" => (float) str_replace(",", "", $item['total_iva']),
                    ":fecha" => date("Y-m-d")
                ));
            }
            $isOk = true;
            foreach ($itemsSql as $detail) {
                $insert = $con->SQ(
                    "INSERT INTO detalle_factura (idfactura, idproducto, cantidad, precio, descuento, iva, total, fecha)
                    VALUE (:idfactura, :idproducto, :cantidad, :precio, :descuento, :iva, :total, :fecha)",
                    $detail
                );
                $codigo = $detail[':idproducto'];
                $cantidad = (int) $detail[':cantidad'];
                $stock = $con->SQR_ONEROW("SELECT stock FROM producto WHERE idproducto = $codigo");
                $stockNow = (int) $stock['data']['stock'];
                $newSotck = $stockNow - $cantidad;
                $UpdateStock = $con->SQ("UPDATE producto SET stock = :newSotck WHERE idproducto = $codigo", array(":newSotck" => $newSotck));

                if ($insert['error'] != '00000') $isOk = false;
                if ($stock['error'] != '00000') $isOk = false;
                if ($UpdateStock['error'] != '00000') $isOk = false;
            }
            if ($isOk) {
                $insert = $con->SQ("UPDATE consecutivos SET fac = :consecutivo", array(':consecutivo' => (int) $consecutivo));
                $result['data']['fac'] = $consecutivo;
                return  $result;
            } else {
                $delete = $con->SQ("DELETE *   FROM facturas WHERE consecutivo=:consecutivo", array(":consecutivo" => $consecutivo));
                return  $result;
            }
        } else {
            echo '<pre>';
            print_r($result);
            echo '</pre>';
            return  $result;
        }
    }
    public static function setAbonoRecibo($data, $abono)
    {

        $con = new conexion();
        if (!$abono) {
            unset($data[':idusuario']);
            unset($data[':idcliente']);
            unset($data[':impuesto']);
            unset($data[':descuento']);
            unset($data[':total']);
            unset($data[':tipo']);
            unset($data[':estado']);
            unset($data[':comentario']);
            unset($data[':idcaja']);
            unset($data[':monto_envio']);
            unset($data[':saldo_ref']);
            unset($data[':new_saldo']);
            unset($data[':hasSaldo']);
            unset($data[':saldo']);
            $data[':idusuario'] = $_SESSION['id'];
        }
        $data[':fechaFormat'] = date("Y-m-d");
        $data[':idcaja'] = $_SESSION['idcaja'];
        $recibo = $con->SQ(
            "INSERT INTO recibos (idfactura, abono, efectivo, fechaFormat, tarjeta, transferencia, monto_transferencia, monto_tarjeta, monto_efectivo,
            numero_tarjeta,banco_transferencia, referencia_transferencia, idusuario, idcaja, multipago_string, multipago, multipago_total) 
            VALUES (:idfactura, :abono, :efectivo, :fechaFormat, :tarjeta, :transferencia, :monto_transferencia, :monto_tarjeta, :monto_efectivo,:numero_tarjeta,:banco_transferencia,
             :referencia_transferencia, :idusuario, :idcaja, :multipago_string, :multipago, :multipago_total)",
            $data
        );
        if ($recibo['error'] == '00000') {
            $id = $_SESSION['id'];
            $idfactura = $data[':idfactura'];
            $sql = "SELECT MAX(r.idrecibo)  AS idrecibo,
                    (SELECT SUM(sr.abono) FROM recibos AS sr WHERE sr.idfactura =$idfactura GROUP BY sr.idfactura) AS AbonoTotal,
                    (SELECT f.total FROM facturas AS f WHERE f.consecutivo =$idfactura) AS total, 
                    (SELECT DATE_FORMAT(DATE_ADD(f1.fecha, INTERVAL 31 DAY),'%d-%m-%Y') FROM facturas AS f1 WHERE f1.consecutivo =$idfactura) AS fecha_final,
                    (SELECT DATE_FORMAT(DATE_ADD(f2.fecha, INTERVAL 31 DAY),'%d-%m-%Y') AS fecha_final FROM facturas AS f2 WHERE f2.consecutivo =$idfactura)
                    FROM recibos AS r WHERE r.idfactura =$idfactura";

            $idrecibo = $con->SQR_ONEROW("SELECT MAX(r.idrecibo) AS idrecibo FROM recibos AS r WHERE r.idusuario=$id");
            $extraData = $con->SQR_ONEROW($sql);

            $recibo['idrecibo'] = $idrecibo['data']['idrecibo'];
            $recibo['AbonoTotal'] = $extraData['data']['AbonoTotal'];
            $recibo['total'] = $extraData['data']['total'];
            $recibo['fecha_final'] = $extraData['data']['fecha_final'];
            if ($recibo['AbonoTotal'] == $recibo['total']) {
                $extraData = $con->SQ('UPDATE facturas SET estado =1 WHERE consecutivo =:idfactura', array(":idfactura" => $idfactura));
            }
        }
        return $recibo;
    }
    public static function getFacturaForDevolution($fac)
    {

        $con = new conexion();
        $header = $con->SQR_ONEROW("SELECT *, DATE_FORMAT(f.fecha,'%d-%m-%Y') fechaFormat, DATE_FORMAT(DATE_ADD(f.fecha, INTERVAL 15 DAY),'%d-%m-%Y') AS fecha_final
        FROM facturas f
        INNER JOIN cliente c 
        ON c.idcliente = f.idcliente 
        WHERE  consecutivo = $fac");
        $data = array();
        if ($header['rows'] > 0) {
            $factura = $header['data'];
            $factura['dateNow'] = date("d-m-Y");
            // $factura['dateNow'] = "12-12-2020";
            $id = (int) $factura['consecutivo'];
            $detalis = $con->SQND("SELECT p.codigo, d.idproducto, p.descripcion,p.descripcion_short, p.marca, p.estilo, d.cantidad, d.descuento, d.iva, d.precio, d.total 
            FROM detalle_factura d 
            INNER JOIN producto p 
            ON p.idproducto = d.idproducto 
            WHERE d.idfactura =$id");
            if ($detalis['rows'] > 0) {
                $factura['details'] = $detalis['data'];
            }
            $data = $factura;
            $data['hasDevolution'] = false;
            //verificamos si existe una devolucion ligada a la factura
            $facDevolution = $con->SQR_ONEROW("SELECT * FROM devoluciones WHERE fac = $fac");
            if ($facDevolution['rows'] > 0) {
                $data['hasDevolution'] = true;
                $data['devolucion_details'] = $facDevolution['data'];
                $idDevolucion = $facDevolution['data']['idDevolucion'];
                $facDevolution = $con->SQND("SELECT * FROM detalles_devoluciones WHERE idDevolucion= $idDevolucion");
                $data['productosDevoluciones'] =  $facDevolution['data'];
                $data['detailsOriginal'] = $data['details'];
                //recorre cada row de productos de la factura
                foreach ($data['details'] as $key => $product) {
                    $data['details'][$key]['originalCant'] = $product['cantidad'];
                    //recorre por cada producto de la factura original, recorre las devoluciones y verifica si son iguales y le reduce la cantidad
                    foreach ($data['productosDevoluciones'] as $productDevolution) {
                        if ($product['idproducto'] == $productDevolution['idProducto']) {
                            $data['details'][$key]['originalCant'] = $product['cantidad'];
                            if ($product['cantidad'] > 0) {
                                $data['details'][$key]['cantidad'] = (int)($data['details'][$key]['cantidad'] - $productDevolution['cantidad']);
                            }
                        }
                    }
                }
            }
        } else {
            $data = null;
        }
        return $data;
    }
    public static function setDevolucion($data)
    {

        $fac = trim($data['fac']);
        $date = DateTime::createFromFormat('d-m-Y', $data['fechaMax']);
        $fechaMax = $date->format('Y-m-d');
        $iduser = $_SESSION['id'];
        $total = (float) $data['total'];
        $con = new conexion();
        $ok = true;
        $saveLogs = [];
        //verificamos si existe una devolucion ligada a la factura
        $result = $con->SQR_ONEROW("SELECT * FROM devoluciones WHERE fac = $fac");
        //validamos si encontro algun registro relacionado
        if ($result['rows'] == 0) {
            //Insertamos la devolucion nueva
            $newDevolucion = $con->SQNDNR("INSERT INTO devoluciones (fac, fechaMaxReclamo, idUsuario, total, Saldo) VALUE ($fac, '$fechaMax', $iduser, $total, $total)");
            if ($newDevolucion['error'] == '00000') {
                $saveLogs['newDevolucion'] = admin::saveLog("Insertar", "Facturacion", "se genera una devolucion a la factura #$fac", json_encode($data), $_SESSION['id']);
            }
            //verificamos que no haya errores
            if ($newDevolucion['error'] == '00000' && $newDevolucion['estado'] == true) {
                //obtener el IdDevolucion para asignar al detalle de productos
                $result = $con->SQR_ONEROW("SELECT idDevolucion FROM devoluciones WHERE fac = $fac");
                $idDevolucion = $result['data']['idDevolucion'];
                foreach ($data['items'] as $row) {
                    $idproducto = $row['idproducto'];
                    $cant = $row['cant'];
                    $total = $row['total'];
                    $newDetalles = $con->SQNDNR("INSERT INTO detalles_devoluciones (idDevolucion, idProducto, cantidad, monto) VALUE ($idDevolucion, '$idproducto', $cant, $total)");
                    //validamos por cada insercion que no haya errores
                    if ($newDetalles['error'] != '00000' && $newDetalles['estado'] != true) {
                        $ok = false;
                    } else {
                        //por cada devolucion se retorna la cantidad de producto especificado al stock
                        $stockNow = $con->SQR_ONEROW("SELECT stock FROM producto  WHERE idproducto=$idproducto");
                        $newStock = (int)$stockNow['data']['stock'] + (int)$cant;
                        $sql = "UPDATE producto SET stock=$newStock WHERE idproducto=$idproducto";
                        $updateProduct = $con->SQNDNR($sql);
                        if ($updateProduct['error'] != '00000') {
                            $ok = false;
                        }
                        if ($updateProduct['error'] == '00000') {
                            $saveLogs['updateProduct'] = admin::saveLog("Actualizar", "Facturacion", "Actualizacion de stock por devolucion ID: $idproducto  cantidad: $cant", json_encode(array("idDevolucion" => $idDevolucion, "idproducto" => $idproducto, "cantidad" => $cant, "total" => $total)), $_SESSION['id']);
                        }
                    }
                }
            }
            //verificamos si la factura ya tiene una devolucion ligada
        } else if ($result['rows'] == 1) {

            $saldo  = (float) $result['data']['Saldo'];
            $NowTotal  = (float) $result['data']['total'];
            $newSaldo =  (float) ($saldo + $total);
            $newTotal =  (float) ($NowTotal + $total);
            //obtener el IdDevolucion
            $idDevolucion = $result['data']['idDevolucion'];
            foreach ($data['items'] as $row) {
                $idproducto = $row['idproducto'];
                $cant = $row['cant'];
                $total = $row['total'];
                $newDetalles = $con->SQNDNR("INSERT INTO detalles_devoluciones (idDevolucion, idProducto, cantidad, monto) VALUE ($idDevolucion, '$idproducto', $cant, $total)");
                //validamos por cada insercion que no haya errores
                if ($newDetalles['error'] != '00000' && $newDetalles['estado'] != true) {
                    $ok = false;
                } else {
                    //por cada devolucion se retorna la cantidad de producto especificado al stock
                    $stockNow = $con->SQR_ONEROW("SELECT stock FROM producto  WHERE idproducto=$idproducto");
                    $newStock = (int)$stockNow['data']['stock'] + (int)$cant;
                    $sql = "UPDATE producto SET stock=$newStock WHERE idproducto=$idproducto";
                    $updateProduct = $con->SQNDNR($sql);
                    if ($updateProduct['error'] != '00000') {
                        $ok = false;
                    }
                }
            }
            if ($ok) {
                $newDetalles = $con->SQNDNR("UPDATE devoluciones SET total =$newTotal, Saldo = $newSaldo WHERE fac =$fac");
            }
        }
        return array("estado" => $ok, "saveLogData" => $saveLogs);
    }
    public static function saldoDevoluciones($fac)
    {

        $con = new conexion();
        $data = $con->SQR_ONEROW("SELECT * FROM  devoluciones WHERE fac = $fac");
        return $data;
    }
    public static function setFirstAbonoRecibo()
    {
        $con = new conexion();
        $data = $con->SPCALL("SELECT *,f.estado AS fac_estado FROM  facturas AS f INNER JOIN cliente AS c ON c.idcliente = f.idcliente WHERE f.estado = 0 AND f.tipo > 1");
        return $data;
    }

    public static function getFacToRePrint(int $fac): array
    {
        $con = new conexion();
        $facHeader = $con->SPCALL("SELECT *, c.nombre cliente, u.nombre cajero, f.consecutivo fac,f.impuesto, f.fecha, f.descuento,  f.monto_efectivo, f.monto_tarjeta, 
        f.monto_transferencia, f.monto_envio, f.total, f.tipo, f.multipago_string otherCards
        FROM facturas f 
        INNER JOIN cliente c ON c.idcliente = f.idcliente 
        INNER JOIN usuario u ON u.idusuario = f.idusuario 
        WHERE f.consecutivo = $fac");

        $facRows = $con->SPCALL("SELECT d.idproducto id, p.codigo cod, CONCAT( p.descripcion_short , ' | ' , p.estilo) descripcion , t.talla, d.cantidad, d.iva, d.descuento, 
                                    d.precio, ((d.precio) - (d.precio) * (d.descuento /100) ) subtotal ,d.total total_iva FROM detalle_factura d 
                                    INNER JOIN producto p ON p.idproducto = d.idproducto 
                                    INNER JOIN tallas t ON t.idtallas = p.idtalla 
                                    WHERE d.idfactura =$fac");

        return array("header" => $facHeader, "rows" => $facRows);
    }
    public static function getHistorialDiario($start = null, $end = null)
    {
        if ($start  == null && $end == null) {
            $start = date('Y-m-d');
            $end = date('Y-m-d');
        }
        $con = new conexion();
        $iduser = $_SESSION['id'];
        $rol = (int)$_SESSION['idrol'];

        $nameRol = strtoupper($_SESSION['rolname']);
        $find   = 'ADMIN';
        $pos = strpos($nameRol, $find);
        $sql  = "SELECT f.*, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat, c.nombre cliente FROM facturas f LEFT JOIN cliente c on c.idcliente = f.idcliente WHERE formatDate BETWEEN '$start' AND '$end' AND idusuario = $iduser AND f.estado <> '2' ORDER BY consecutivo DESC";
        $sql1 = "SELECT f.*, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat, c.nombre cliente FROM facturas f LEFT JOIN cliente c on c.idcliente = f.idcliente WHERE formatDate BETWEEN '$start' AND '$end' AND f.estado <> '2' ORDER BY consecutivo DESC";
        $sql2 = "SELECT f.*, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat, c.nombre cliente FROM facturas f LEFT JOIN cliente c on c.idcliente = f.idcliente WHERE formatDate BETWEEN '$start' AND '$end' AND idusuario = $iduser AND f.estado <> '2' ORDER BY consecutivo DESC";
        if ($pos === false) {
            $sql = $sql2;
        } else {
            $sql = $sql1; //admin
        }


        $header = $con->SPCALL($sql);
        $data = array();
        if ($header['rows'] > 0) {
            foreach ($header['data'] as $factura) {
                $id = (int) $factura['consecutivo'];
                $tipo = (int) $factura['tipo'];
                $detalis = $con->SQND("SELECT p.codigo, d.idproducto, p.descripcion, p.marca, p.estilo, d.cantidad, d.descuento, d.iva, d.precio, d.total, t.talla FROM detalle_factura d 
                INNER JOIN producto p ON p.idproducto = d.idproducto 
                INNER JOIN tallas t ON t.idtallas = p.idtalla 
                WHERE d.idfactura =$id");
                if ($detalis['rows'] > 0) {
                    $factura['details'] = $detalis['data'];
                } else {
                    $factura['details'] = $detalis['data'];
                }
                if ($tipo == 3) {
                    $recibosList = $con->SQND("SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat,  (SELECT SUM(r2.abono) FROM recibos AS r2 WHERE idfactura =$id ) AS fullAbono  FROM recibos r WHERE r.idfactura =$id");
                    $factura['fullAbono'] = $recibosList['data'][0]['fullAbono'];
                    $factura['recibos'] = $recibosList['data'];
                }
                array_push($data, $factura);
            }
        }
        return $data;
    }
    public static function lastFactRePrint()
    {
        $con = new conexion();
        $iduser = $_SESSION['id'];
        $header = $con->SPCALL("SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat, fecha FROM facturas  WHERE  idusuario = $iduser AND tipo <> 3 ORDER BY consecutivo DESC LIMIT 100");
        $data = array();
        if ($header['rows'] > 0) {
            foreach ($header['data'] as $factura) {
                $id = (int) $factura['consecutivo'];
                $tipo = (int) $factura['tipo'];
                $detalis = $con->SQND("SELECT p.codigo, d.idproducto, p.descripcion, p.marca, p.estilo, d.cantidad, d.descuento, d.iva, d.precio, d.total, t.talla FROM detalle_factura d 
                INNER JOIN producto p ON p.idproducto = d.idproducto 
                INNER JOIN tallas t ON t.idtallas = p.idtalla 
                WHERE d.idfactura =$id");
                if ($detalis['rows'] > 0) {
                    $factura['details'] = $detalis['data'];
                }
                if ($tipo == 3) {
                    $recibosList = $con->SQND("SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat,  (SELECT SUM(r2.abono) FROM recibos AS r2 WHERE idfactura =$id ) AS fullAbono  FROM recibos r WHERE r.idfactura =$id");
                    $factura['fullAbono'] = $recibosList['data'][0]['fullAbono'];
                    $factura['recibos'] = $recibosList['data'];
                }
                array_push($data, $factura);
            }
        }
        return $data;
    }
    public static function searchFacByNumber($fac)
    {
        $con = new conexion();
        $iduser = $_SESSION['id'];
        $header = $con->SPCALL("SELECT f.*, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat, fecha, c.nombre cliente FROM facturas as f
        LEFT JOIN cliente c ON c.idcliente = f.idcliente 
        WHERE consecutivo = $fac");
        $data = array();
        if ($header['rows'] > 0) {
            foreach ($header['data'] as $factura) {
                $id = (int) $factura['consecutivo'];
                $tipo = (int) $factura['tipo'];
                $detalis = $con->SQND("SELECT p.codigo, d.idproducto, p.descripcion, p.marca, p.estilo, d.cantidad, d.descuento, d.iva, d.precio, d.total, t.talla FROM detalle_factura d 
                INNER JOIN producto p ON p.idproducto = d.idproducto 
                INNER JOIN tallas t ON t.idtallas = p.idtalla 
                WHERE d.idfactura =$id");
                if ($detalis['rows'] > 0) {
                    $factura['details'] = $detalis['data'];
                } else {
                    $factura['details'] = $detalis['data'];
                }
                if ($tipo == 3) {
                    $recibosList = $con->SQND("SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat,  (SELECT SUM(r2.abono) FROM recibos AS r2 WHERE idfactura =$id ) AS fullAbono  FROM recibos r WHERE r.idfactura =$id");
                    $factura['fullAbono'] = $recibosList['data'][0]['fullAbono'];
                    $factura['recibos'] = $recibosList['data'];
                }
                array_push($data, $factura);
            }
        }
        return $data;
    }
    public static function apartadosSinCancelar()
    {
        $con = new conexion();
        $iduser = $_SESSION['id'];
        $header = $con->SPCALL("SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat, DATE_FORMAT(DATE_ADD(fecha, INTERVAL 30 DAY),'%d-%m-%Y') AS fecha_final FROM facturas  WHERE idusuario=$iduser AND tipo = 3 ORDER BY consecutivo DESC LIMIT 100");
        $data = array();
        if ($header['rows'] > 0) {
            foreach ($header['data'] as $factura) {
                $id = (int) $factura['consecutivo'];
                $tipo = (int) $factura['tipo'];
                $detalis = $con->SQND("SELECT p.codigo, d.idproducto, p.descripcion, p.marca, p.estilo, d.cantidad, d.descuento, d.iva, d.precio, d.total FROM detalle_factura d INNER JOIN producto p ON p.idproducto = d.idproducto WHERE d.idfactura =$id");
                if ($detalis['rows'] > 0) {
                    $factura['details'] = $detalis['data'];
                }
                if ($tipo == 3) {
                    $recibosList = $con->SQND("SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat,  (SELECT SUM(r2.abono) FROM recibos AS r2 WHERE idfactura =$id ) AS fullAbono  FROM recibos r WHERE r.idfactura =$id");
                    $factura['fullAbono'] = $recibosList['data'][0]['fullAbono'];
                    $factura['recibos'] = $recibosList['data'];
                }
                array_push($data, $factura);
            }
        }
        return $data;
    }
    public static function getPendingFac()
    {
        $con = new conexion();
        $data = $con->SPCALL("SELECT f.idfactura,f.consecutivo,DATE_FORMAT(f.fecha,'%d-%m-%Y') as fecha,f.tipo, c.nombre,f.total,f.estado AS fac_estado,IF(SUM(f.efectivo + f.tarjeta+ f.efectivo )=0,0,1) AS cancelado 
                            FROM  facturas AS f INNER JOIN cliente AS c ON c.idcliente = f.idcliente 
                            WHERE f.estado = 0 AND NOT(f.tipo= 1) GROUP BY f.consecutivo ORDER BY f.tipo DESC
        ");
        return $data;
    }
    public static function pendientesProductos($id)
    {
        $con = new conexion();
        $data = $con->SPCALL("SELECT df.*, p.descripcion, p.idtalla, (IF(p.iva>0,1,0)) AS iva, p.iddescuento,(IF(p.iddescuento>0,1,0)) AS descuento, t.talla FROM detalle_factura AS df 
        INNER JOIN producto AS p ON p.idproducto = df.idproducto 
        INNER JOIN tallas AS t ON t.idtallas = p.idtalla
        WHERE  df.idfactura = $id");
        return $data;
    }
    public static function changeStateFac($data)
    {
        $con = new conexion();
        $data = $con->SQ("UPDATE facturas SET estado = 1 WHERE consecutivo=:consecutivo", $data);
        return $data;
    }
    public static function setAbrirCaja($data)
    {
        $con = new conexion();
        $data = $con->SQ("INSERT INTO cajas (idusuario_openbox, idvendedor, caja_base, fecha_init, estado) VALUES (:id, :userId, :monto,:fecha_init, 0)", $data);
        return $data;
    }

    public static function abrirCajaEstado($data)
    {
        $con = new conexion();
        $data = $con->SQ("UPDATE cajas SET estado = 1 WHERE idcaja=:idcaja", $data);
        return $data;
    }
    public static function obtenerEstadoCajaEstadoPagos2($data)
    {
        $con = new conexion();
        $data1 = $con->SRQ("SELECT (SUM(r.monto_efectivo)+IF((SELECT SUM(monto_efectivo) FROM recibos WHERE idcaja =:idcaja)>0,(SELECT SUM(monto_efectivo) FROM recibos WHERE idcaja =:idcaja),0)) AS total_efectivo,
        (SUM(r.monto_tarjeta)+IF((SELECT SUM(monto_tarjeta) FROM recibos WHERE idcaja =:idcaja)>0,(SELECT SUM(monto_tarjeta) FROM recibos WHERE idcaja =:idcaja),0)) AS total_tarjeta,
        (SUM(r.monto_transferencia) + IF((SELECT SUM(monto_transferencia) FROM recibos WHERE idcaja =:idcaja)>0,(SELECT SUM(monto_transferencia) FROM recibos WHERE idcaja =:idcaja),0)) AS total_transferencia
        FROM facturas AS r WHERE idcaja =:idcaja GROUP BY idcaja", $data);
        return $data1;
    }
    public static function obtenerEstadoCajaEstadoPagos($data)
    {
        $con = new conexion();

        $total_facturas="(SELECT SUM(total) FROM facturas WHERE idcaja =:idcaja)  AS total_facturas";
        $total_recibos="(SELECT SUM(abono) FROM recibos WHERE idcaja = :idcaja) AS total_recibos";
        $recibos_monto_efectivo="(SELECT SUM(monto_efectivo) FROM recibos WHERE idcaja = :idcaja) AS recibos_monto_efectivo";
        $recibos_monto_tarjeta="(SELECT SUM(monto_tarjeta) FROM recibos WHERE idcaja = :idcaja) AS recibos_monto_tarjeta";
        $recibos_monto_transferencia="(SELECT SUM(monto_transferencia) FROM recibos WHERE idcaja = :idcaja) AS recibos_monto_transferencia";
        $recibos_multipago_total="(SELECT SUM(multipago_total) FROM recibos WHERE idcaja = :idcaja) AS recibos_multipago_total";
        $facturas_monto_efectivo="(SELECT SUM(monto_efectivo) FROM facturas WHERE idcaja = :idcaja) AS facturas_monto_efectivo";
        $facturas_monto_transferencia="(SELECT SUM(monto_transferencia) FROM facturas WHERE idcaja = :idcaja) AS facturas_monto_transferencia";
        $facturas_multipago_total="(SELECT SUM(multipago_total) FROM facturas WHERE idcaja = :idcaja) AS facturas_multipago_total";
        $facturas_monto_tarjeta="(SELECT SUM(monto_tarjeta) FROM facturas WHERE idcaja = :idcaja) AS facturas_monto_tarjeta";



        $totales = $con->SRQ("SELECT $total_facturas, $total_recibos, $recibos_monto_efectivo, $recibos_monto_tarjeta, $recibos_monto_transferencia, $recibos_multipago_total, $facturas_monto_efectivo, $facturas_monto_transferencia, $facturas_multipago_total, $facturas_monto_tarjeta", $data);

        $recibos_monto_efectivo = $totales['data']['recibos_monto_efectivo'];
        $recibos_monto_tarjeta = $totales['data']['recibos_monto_tarjeta'];
        $recibos_monto_transferencia = $totales['data']['recibos_monto_transferencia'];
        $recibos_multipago_total = $totales['data']['recibos_multipago_total'];
        $facturas_monto_transferencia = $totales['data']['facturas_monto_transferencia'];
        $facturas_monto_efectivo = $totales['data']['facturas_monto_efectivo'];
        $facturas_monto_tarjeta = $totales['data']['facturas_monto_tarjeta'];
        $facturas_multipago_total = $totales['data']['facturas_multipago_total'];
        $totalEfectivo = (float)($recibos_monto_efectivo + $facturas_monto_efectivo);
        $totalTarjeta = (float)($recibos_monto_tarjeta + $facturas_monto_tarjeta + $facturas_multipago_total + $recibos_multipago_total);
        $totalTransferencia = (float)($recibos_monto_transferencia + $facturas_monto_transferencia);
        $totales['efectivo'] = $totalEfectivo;
        $totales['tarjeta'] = $totalTarjeta;
        $totales['transferencia'] = $totalTransferencia;
        $totales['total_general'] = (float)($totalEfectivo + $totalTarjeta + $totalTransferencia);
        return $totales;
    }
    public static function getCajas()
    {
        $con = new conexion();
        $data = $con->SQND("SELECT c.*,u.nombre, u2.nombre AS nombre_vendedor 
        FROM  cajas AS c 
        INNER JOIN usuario AS u 
        ON u.idusuario = c.idusuario_openbox 
        INNER JOIN usuario AS u2 
        ON u2.idusuario = c.idvendedor WHERE NOT c.estado =3");
        return $data;
    }
    public static function getCajasIDUpdate()
    {
        $con = new conexion();
        $data = $con->SQND("SELECT c.idcaja FROM cajas c");
        return $data;
    }
    public static function updateCajasTotal($id, $total)
    {
        $con = new conexion();
        $data = $con->SQNDNR("UPDATE cajas SET total_facturado = $total WHERE idcaja = $id");
        return $data;
    }
    public static function getLastMonthCajas()
    {
        $con = new conexion();
        $data = $con->SQND("SELECT c.idcaja, u.nombre, c.caja_base, c.efectivo, c.tarjetas, c.transferencias, c.total_facturado, c.diferencia,c.comentario, c.fecha_init FROM cajas c
        INNER JOIN usuario u 
        ON c.idusuario_openbox = u.idusuario 
        WHERE c.fecha_init > NOW() - INTERVAL 1 MONTH AND c.estado = 3 ORDER BY c.idcaja DESC");
        return $data;
    }
    public static function cerrarCajafinal($datos)
    {
        $con = new conexion();
        $data = $con->SQ("UPDATE cajas SET total_facturado = :total_facturado, efectivo=:efectivo, tarjetas=:tarjeta, transferencias=:transferencia, diferencia =:diferencia, comentario =:comentario, estado =3 WHERE idcaja=:id ", $datos);
        return $data;
    }
    public static function cajaAsignada($datos)
    {
        $con = new conexion();
        $data = $con->SRQ("SELECT * from cajas AS c WHERE c.idvendedor = :id AND c.fecha_init =:fecha  AND c.estado = 1", $datos);
        return $data;
    }
    public static function getApartadosHasClient($cliente)
    {
        $con = new conexion();
        $data = $con->SQND("SELECT DATE_FORMAT(f.fecha,'%d-%m-%Y') as fecha, DATE_FORMAT(DATE_ADD(f.fecha, INTERVAL 30 DAY),'%d-%m-%Y') AS fecha_final,f.consecutivo,f.total,f.idcliente,f.idusuario,SUM(r.monto_transferencia+r.monto_tarjeta+r.monto_efectivo) AS abonado 
                            FROM facturas AS f 
                            INNER JOIN recibos AS r
                            ON r.idfactura = f.consecutivo 
                            WHERE (f.idcliente = $cliente AND f.tipo =3  AND f.estado=0) 
                            GROUP BY r.idfactura");
        return $data;
    }
    public static function getApartadoSaldoHasClientByFac($idfactura){
        $con = new conexion();
        $query = "SELECT DATE_FORMAT(f.fecha,'%d-%m-%Y') as fecha, 
                        DATE_FORMAT(DATE_ADD(f.fecha, INTERVAL 30 DAY),'%d-%m-%Y') AS fecha_final,
                        f.consecutivo,
                        f.total,
                        f.idcliente,
                        f.idusuario,
                        SUM(r.monto_transferencia+r.monto_tarjeta+r.monto_efectivo) AS abonado,
                        FORMAT(f.total - SUM(r.monto_transferencia + r.monto_tarjeta + r.monto_efectivo), 2) AS saldo
                 FROM facturas AS f 
                 INNER JOIN recibos AS r
                 ON r.idfactura = f.consecutivo 
                 WHERE f.consecutivo = $idfactura
                 GROUP BY r.idfactura";
        
        $data = $con->SQND($query);
        return $data;
        
    }
    public static function getProductsFromApartado($fac)
    {
        $con = new conexion();
        $data = $con->SQND("SELECT d.*, p.descripcion_short FROM detalle_factura AS d
                            INNER JOIN producto AS p ON d.idproducto = p.idproducto
                            WHERE d.idfactura= $fac");
        return $data;
    }
    public static function setAbono($fac)
    {
        $con = new conexion();
        $data = $con->SQND("SELECT d.*, p.descripcion_short FROM detalle_factura AS d
                            INNER JOIN producto AS p ON d.idproducto = p.idproducto
                            WHERE d.idfactura= $fac");
        return $data;
    }
}
