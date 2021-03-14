<?php

namespace models;

use config\helper as h;
use config\conexion;

class estadisticasModel
{
    public static function getMoreSalesPerMonth()
    {
        $con = new conexion();
        $sql="SELECT df.idproducto AS id, p.descripcion_short AS descripcion, p.codigo,p.marca, p.estilo, p.idcategoria, SUM(df.cantidad) AS cantidad_Total, SUM(df.total) AS total, f.formatDate AS fecha
        FROM detalle_factura AS df 
        INNER JOIN facturas AS f 
        ON df.idfactura = f.consecutivo 
        INNER JOIN producto AS  p 
        ON df.idproducto = p.idproducto
        WHERE f.formatDate > NOW() - INTERVAL 1 MONTH	
        GROUP BY p.idproducto
        ORDER BY cantidad_total DESC 
        LIMIT 5";
        return $con->SQND("$sql");
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
}
