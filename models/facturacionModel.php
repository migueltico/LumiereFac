<?php

namespace models;

use config\helper as h;
use config\conexion;

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
        $data[':formatDate'] = date("Y-m-d");
        $headerSql = "
        INSERT INTO facturas 
        (consecutivo,idcaja,idusuario,idcliente,impuesto,descuento,total,tipo,efectivo,tarjeta,transferencia,banco_transferencia,
        referencia_transferencia,monto_transferencia,numero_tarjeta,monto_tarjeta,monto_efectivo,monto_envio,estado,comentario,multipago_String,multipago,multipago_total,formatDate) 
        VALUE (:consecutivo, :idcaja, :idusuario, :idcliente, :impuesto, :descuento, :total, :tipo, :efectivo, :tarjeta, :transferencia, :banco_transferencia, :referencia_transferencia, :monto_transferencia, :numero_tarjeta, 
        :monto_tarjeta, :monto_efectivo, :monto_envio, :estado, :comentario, :multipago_string, :multipago, :multipago_total, :formatDate);";
        $result = $con->SQ($headerSql, $data);

        $insert = $con->SQ("UPDATE consecutivos SET fac = :consecutivo", array(':consecutivo' => (int) $consecutivo));
        if ($result['error'] == '00000') {
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
                    ":total" => (float) str_replace(",", "", $item['total_iva'])
                ));
            }


            $result3 = $con2->Sqlforeach('CALL sp_insertFactDetails(:idfactura, :idproducto, :cantidad, :precio, :descuento, :iva, :total)', $itemsSql);
            if ($result3['error'] == '00000') {
                $insert = $con->SQ("UPDATE consecutivos SET fac = :consecutivo", array(':consecutivo' => (int) $consecutivo));
                $result['data']['fac'] = $consecutivo;
                return  $result;
            } else {
                $delete = $con->SQ("DELETE *   FROM facturas WHERE consecutivo=:consecutivo", array(":consecutivo" => $consecutivo));
                return  $result3;
            }
        } else {
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
            $data[':idusuario'] = $_SESSION['id'];
        }
        $data[':idcaja'] = $_SESSION['idcaja'];
        $recibo = $con->SQ(
            "INSERT INTO recibos (idfactura, abono, efectivo, tarjeta, transferencia, monto_transferencia, monto_tarjeta, monto_efectivo,
            numero_tarjeta,banco_transferencia, referencia_transferencia, idusuario, idcaja, multipago_string, multipago, multipago_total) 
            VALUES (:idfactura, :abono, :efectivo, :tarjeta, :transferencia, :monto_transferencia, :monto_tarjeta, :monto_efectivo,:numero_tarjeta,:banco_transferencia,
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
    public static function setFirstAbonoRecibo()
    {
        $con = new conexion();
        $data = $con->SPCALL("SELECT *,f.estado AS fac_estado FROM  facturas AS f INNER JOIN cliente AS c ON c.idcliente = f.idcliente WHERE f.estado = 0 AND f.tipo > 1");
        return $data;
    }
    public static function getHistorialDiario()
    {
        $con = new conexion();
        $iduser = $_SESSION['id'];
        $header = $con->SPCALL("SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y') fechaFormat FROM facturas  WHERE  idusuario = $iduser ORDER BY consecutivo DESC");
        $data = array();
        if ($header['rows'] > 0) {
            foreach ($header['data'] as $factura) {
                $id = (int) $factura['consecutivo'];
                $tipo = (int) $factura['tipo'];
                $detalis = $con->SQND("SELECT d.idproducto, p.descripcion, p.marca, p.estilo, d.cantidad, d.descuento, d.iva, d.precio, d.total FROM detalle_factura d INNER JOIN producto p ON p.idproducto = d.idproducto WHERE d.idfactura =$id");
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
                $detalis = $con->SQND("SELECT d.idproducto, p.descripcion, p.marca, p.estilo, d.cantidad, d.descuento, d.iva, d.precio, d.total FROM detalle_factura d INNER JOIN producto p ON p.idproducto = d.idproducto WHERE d.idfactura =$id");
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
        $totales = $con->SRQ("SELECT 
        (SELECT SUM(total) FROM facturas WHERE idcaja =:idcaja)  AS total_facturas,  
        (SELECT SUM(abono) FROM recibos WHERE idcaja = :idcaja) AS total_recibos,
        (SELECT SUM(monto_efectivo) FROM recibos WHERE idcaja = :idcaja) AS recibos_monto_efectivo, 
        (SELECT SUM(monto_tarjeta) FROM recibos WHERE idcaja = :idcaja) AS recibos_monto_tarjeta, 
        (SELECT SUM(monto_transferencia) FROM recibos WHERE idcaja = :idcaja) AS recibos_monto_transferencia, 
        (SELECT SUM(multipago_total) FROM recibos WHERE idcaja = :idcaja) AS recibos_multipago_total, 
        (SELECT SUM(monto_efectivo) FROM facturas WHERE idcaja = :idcaja) AS facturas_monto_efectivo, 
        (SELECT SUM(monto_transferencia) FROM facturas WHERE idcaja = :idcaja) AS facturas_monto_transferencia, 
        (SELECT SUM(multipago_total) FROM facturas WHERE idcaja = :idcaja) AS facturas_multipago_total, 
        (SELECT SUM(monto_tarjeta) FROM facturas WHERE idcaja = :idcaja) AS facturas_monto_tarjeta", $data);
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
    public static function cerrarCajafinal($datos)
    {
        $con = new conexion();
        $data = $con->SQ("UPDATE cajas SET efectivo=:efectivo, tarjetas=:tarjeta, transferencias=:transferencia, diferencia =:diferencia, comentario =:comentario, estado =3 WHERE idcaja=:id ", $datos);
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
