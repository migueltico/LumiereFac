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
        $insert = $con->SQ("UPDATE consecutivos SET fac = :consecutivo", array(':consecutivo' =>(int) $consecutivo));
        $result = $con->Multitransaction(
            "CALL sp_setFacHeader($consecutivo,:idusuario,:idcliente,:impuesto,:descuento,:total,:tipo,:efectivo,:tarjeta,:transferencia,:banco_transferencia,:referencia_transferencia,:monto_transferencia,:numero_tarjeta,:monto_tarjeta,:monto_efectivo,:estado,:comentario,:idcaja,:monto_envio)",
            $data
        );

        //error_log("result 1: " . json_encode($result) . "\n", 3, "./logs/errors.log");
        if ($result['rows'] == 1) {
            $con2 = new conexion();
            $result2 = $con2->SQR_ONEROW('SELECT * FROM consecutivos WHERE idconsecutivos = 1');
            // echo "<pre>";
            // print_r($result);
            // print_r($result2);
            // echo "</pre>";
            // echo "<pre>";
            // echo "****************";
            // print_r($result2);
            // echo "</pre>";

            if ($result2['data']['fac'] == $result['data']['fac']) {

                $itemsSql = [];

                foreach ($items['items'] as $item) {
                    array_push($itemsSql, array(
                        ":idfactura" => $result['data']['fac'],
                        ":idproducto" => (int) $item['id'],
                        ":cantidad" => (int) $item['cantidad'],
                        ":precio" => (float) str_replace(",", "", $item['precio']),
                        ":descuento" => (int) (rtrim($item['descuento'], "%")),
                        ":iva" => (int) $item['iva'],
                        ":total" => (float) str_replace(",", "", $item['total_iva'])
                    ));
                }

                $result3 = $con2->Sqlforeach('CALL sp_insertFactDetails(:idfactura, :idproducto, :cantidad, :precio, :descuento, :iva, :total)', $itemsSql);
                return  $result;
            } else {
                return   array("rows" => 0, 'estado' => false, 'generalError' => false, 'rollback' => true,  'error' => 'rollback');
            }
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
            "INSERT INTO recibos (idfactura, abono, efectivo, tarjeta, transferencia, monto_transferencia, monto_tarjeta, monto_efectivo,numero_tarjeta,banco_transferencia, referencia_transferencia, idusuario, idcaja) 
            VALUES (:idfactura, :abono, :efectivo, :tarjeta, :transferencia, :monto_transferencia, :monto_tarjeta, :monto_efectivo,:numero_tarjeta,:banco_transferencia, :referencia_transferencia, :idusuario, :idcaja)",
            $data
        );
        if ($recibo['error'] == '00000') {
            $id = $_SESSION['id'];
            $idfactura = $data[':idfactura'];
            $sql = "SELECT MAX(r.idrecibo)  AS idrecibo,
                    (SELECT SUM(sr.abono) FROM recibos AS sr WHERE sr.idfactura =$idfactura GROUP BY sr.idfactura) AS AbonoTotal,
                    (SELECT f.total FROM facturas AS f WHERE f.consecutivo =$idfactura) AS total, 
                    (SELECT DATE_FORMAT(DATE_ADD(f2.fecha, INTERVAL 31 DAY),'%d-%m-%Y') FROM facturas AS f2 WHERE f2.consecutivo =$idfactura) AS fecha_final,
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
        (SELECT SUM(monto_efectivo) FROM facturas WHERE idcaja = :idcaja) AS facturas_monto_efectivo, 
        (SELECT SUM(monto_transferencia) FROM facturas WHERE idcaja = :idcaja) AS facturas_monto_transferencia, 
        (SELECT SUM(monto_tarjeta) FROM facturas WHERE idcaja = :idcaja) AS facturas_monto_tarjeta", $data);
        $recibos_monto_efectivo = $totales['data']['recibos_monto_efectivo'];
        $recibos_monto_tarjeta = $totales['data']['recibos_monto_tarjeta'];
        $recibos_monto_transferencia = $totales['data']['recibos_monto_transferencia'];
        $facturas_monto_transferencia = $totales['data']['facturas_monto_transferencia'];
        $facturas_monto_efectivo = $totales['data']['facturas_monto_efectivo'];
        $facturas_monto_tarjeta = $totales['data']['facturas_monto_tarjeta'];
        $totalEfectivo = (float)($recibos_monto_efectivo + $facturas_monto_efectivo);
        $totalTarjeta = (float)($recibos_monto_tarjeta + $facturas_monto_tarjeta);
        $totalTransferencia = (float)($recibos_monto_transferencia + $facturas_monto_transferencia);
        $totales['efectivo'] = $totalEfectivo;
        $totales['tarjeta'] = $totalTarjeta;
        $totales['transferencia'] = $totalTransferencia;
        return $totales;
    }
    public static function getCajas()
    {
        $con = new conexion();
        $data = $con->SQND("SELECT c.*,u.nombre, u2.nombre AS nombre_vendedor FROM  cajas AS c INNER JOIN usuario AS u ON u.idusuario = c.idusuario_openbox INNER JOIN usuario AS u2 ON u2.idusuario = c.idvendedor");
        return $data;
    }
    public static function cerrarCajafinal($datos)
    {
        $con = new conexion();
        $date = date('Y') . "-" . date('m') . "-" . date('d');
        $data = $con->SQ("UPDATE cajas SET efectivo=:efectivo, tarjetas=:tarjeta, transferencias=:transferencia, diferencia =:diferencia, comentario =:comentario, fecha_close = $date, estado =3 WHERE idcaja=:id ", $datos);
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
