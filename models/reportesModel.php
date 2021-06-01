<?php

namespace models;

use config\helper as h;
use config\conexion;

class reportesModel
{
    public static function getRols()
    {
        $con = new conexion();
        return $con->SQND("SELECT * FROM rol");
    }
    /**
     * Reporte totales factura por dia
     */
    public static function rxfacDia($init, $end)
    {
        $con = new conexion();
        $return = $con->SPCALL("CALL sp_reporteDiario('$init', '$end')");
        return $return;
    }
    /**
     * Reporte totales factura por dia detalle
     */
    public static function rxfacDiaDetalle($init, $end)
    {
        $con = new conexion();
        $return1 = $con->SQND("CALL sp_reporteDiarioDetallado('$init', '$end')");
        return $return1;
    }
    /**
     * Reporte totales factura por dia detalle por metodo pago
     */
    public static function rxfacDiaDetalleMetodoPago($init, $end, $metodo)
    {
        $con = new conexion();
        $return1 = $con->SQND("CALL sp_reporteFacturaDetallada_por_metodo_pago('$init', '$end',$metodo)");
        return $return1;
    }
    /**
     * Reporte ventas por cliente
     */
    public static function rxFacturasXCliente($init, $end)
    {
        $con = new conexion();
        $idgenerico = $con->SQR_ONEROW("SELECT idclienteGenerico FROM generalinfo WHERE idgeneral = 1");
        $id = $idgenerico['data']['idclienteGenerico'];
        $Sql= "SELECT f.formatDate as fecha, f.consecutivo as factura, c.nombre, c.telefono, f.total
                FROM `facturas` AS f 
                INNER JOIN cliente AS c 
                ON c.idcliente = f.idcliente 
                WHERE (f.formatDate 
                BETWEEN '$init' AND '$end') AND (f.idcliente <> $id)";
        $return = $con->SQND($Sql);
        return $return;
    }
}
