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
     * Reporte totales factura por dia
     */
    public static function rxfacDiaDetalle($init, $end)
    {
        $con = new conexion();
        $con2 = new conexion();
        $return1 = $con->SQND("CALL sp_reporteDiarioDetallado('$init', '$end')");
        // $con->disconnect();
        // $return2 = $con2->SQND("CALL sp_reporteDiario('$init', '$end')");
        return $return1;
    }
}
