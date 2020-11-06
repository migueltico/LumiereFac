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
        $result = $con->Multitransaction(
            'CALL sp_setFacHeader(:idusuario,:idcliente,:impuesto,:descuento,:total,:tipo,:efectivo,:tarjeta,:transferencia,:banco_transferencia,:referencia_transferencia,:monto_transferencia,:numero_tarjeta,:monto_tarjeta,:monto_efectivo,:estado,:comentario,:idcaja)',
            $data
        );
        if ($result['rows'] == 1) {
            $con2 = new conexion();
            $result2 = $con2->SQR_ONEROW('SELECT * FROM consecutivos WHERE idconsecutivos = 1');
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
    public static function setAbonoRecibo()
    {
        $con = new conexion();
        $data = $con->SPCALL("SELECT *,f.estado AS fac_estado FROM  facturas AS f INNER JOIN cliente AS c ON c.idcliente = f.idcliente WHERE f.estado = 0 AND f.tipo > 1");
        return $data;
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
        $data = $con->SPCALL("SELECT *,f.estado AS fac_estado FROM  facturas AS f INNER JOIN cliente AS c ON c.idcliente = f.idcliente WHERE f.estado = 0 AND f.tipo > 1");
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
    public static function cerrarCajaEstado($data)
    {
        $con = new conexion();
        $data1 = $con->SQ("SELECT COUNT(*), SUM(f.monto_efectivo) AS efectivo,SUM(f.monto_tarjeta) AS tarjeta,SUM(f.monto_transferencia) AS transferencia, f.tipo FROM facturas AS f WHERE f.idcaja = 2 AND f.tipo = 1", $data);
        $data2 = $con->SQ("SELECT COUNT(*), SUM(f.monto_efectivo) AS efectivo,SUM(f.monto_tarjeta) AS tarjeta,SUM(f.monto_transferencia) AS transferencia, f.tipo FROM facturas AS f WHERE f.idcaja = 2 AND f.tipo = 2", $data);
        $data2 = $con->SQ("SELECT COUNT(*), SUM(f.monto_efectivo) AS efectivo,SUM(f.monto_tarjeta) AS tarjeta,SUM(f.monto_transferencia) AS transferencia, f.tipo FROM facturas AS f WHERE f.idcaja = 2 AND f.tipo = 3", $data);
        return [$data1, $data2];
    }
    public static function getCajas()
    {
        $con = new conexion();
        $data = $con->SQND("SELECT c.*,u.nombre, u2.nombre AS nombre_vendedor FROM  cajas AS c INNER JOIN usuario AS u ON u.idusuario = c.idusuario_openbox INNER JOIN usuario AS u2 ON u2.idusuario = c.idvendedor");
        return $data;
    }
    public static function cajaAsignada($datos)
    {
        $con = new conexion();
        $data = $con->SRQ("SELECT * from cajas AS c WHERE c.idvendedor = :id AND c.fecha_init =:fecha  AND c.estado = 1", $datos);
        return $data;
    }
}
