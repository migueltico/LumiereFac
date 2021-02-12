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
    public static function rxfacDia($init,$end)
    {
        $con = new conexion();
        return $con->SQND("SELECT 
        DATE_FORMAT(f.formatDate,'%d-%m-%Y') fecha,
        COUNT(f.idfactura) cantidad, 
        SUM(f.monto_efectivo) total_efectivo, 
        SUM(f.monto_tarjeta) AS total_tarjeta, 
        SUM(f.monto_transferencia) AS total_transferencia,  
        SUM(f.total) AS total_diario FROM facturas AS f WHERE f.formatDate BETWEEN '$init' AND '$end' AND f.idusuario = 1 GROUP BY f.formatDate");
    }

}
