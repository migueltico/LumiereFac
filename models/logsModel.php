<?php

namespace models;

use config\helper as h;
use config\conexion;

class logsModel
{
    /**
     * Obtiene los registros de logs según los filtros especificados.
     *
     * @param string $startDate Fecha de inicio para filtrar los registros (opcional).
     * @param string $endDate Fecha de fin para filtrar los registros (opcional).
     * @param string $modulo Módulo para filtrar los registros (opcional).
     * @param string $accion Acción para filtrar los registros (opcional).
     * @param string $usuario Usuario para filtrar los registros (opcional).
     * @param int $page Número de página para paginar los resultados (opcional, valor predeterminado: 1).
     * @param int $perPage Cantidad de registros por página (opcional, valor predeterminado: 500).
     * @return array Arreglo con los registros de logs que cumplen con los filtros especificados.
     */
    public static function getLogs($startDate = '', $endDate = '', $modulo = '', $accion = '', $usuario = '', $page = 1, $perPage = 20)
    {
        $less7Days = date('Y-m-d', strtotime('-7 days'));
        $startDate = $startDate == '' ? $less7Days : $startDate;
        $endDate = $endDate == '' ? date('Y-m-d') : $endDate;
    
        $con = new conexion();
        $limit = $perPage;
        $offset = ($page - 1) * $perPage;
    
        $whereClauses = array();
    
        // Construir las cláusulas WHERE según los filtros
        if (!empty($startDate)) {
            $startDate .= ' 00:00:00'; // Agrega el inicio del día
            $endDate .= ' 23:59:59';   // Agrega el final del día
            $whereClauses[] = "creado_el BETWEEN '$startDate' AND '$endDate'";
        }
    
        if (!empty($modulo)) {
            $whereClauses[] = "l.modulo LIKE '%$modulo%'";
        }
    
        if (!empty($accion)) {
            $whereClauses[] = "l.accion LIKE '%$accion%'";
        }
    
        if (!empty($usuario)) {
            $whereClauses[] = "l.idusuario LIKE '%$usuario%'";
        }
    
        $whereClause = implode(" AND ", $whereClauses);
    
        $consulta = "SELECT l.*, u.nombre
            FROM log l
            INNER JOIN usuario u ON l.idusuario = u.idusuario
            " . (!empty($whereClause) ? "WHERE $whereClause" : "") . "
            ORDER BY l.creado_el DESC
            LIMIT $limit OFFSET $offset";
    
        $result = $con->SQND($consulta);
    
        return $result;
    }
    

    public static function getActionsAndModulesFilters()
    {
        $con = new conexion();
        $consulta = "SELECT DISTINCT l.accion
            FROM log l
            ORDER BY l.accion ASC";
        $result1 = $con->MRQ($consulta);

        $consulta = "SELECT DISTINCT l.modulo
            FROM log l
            ORDER BY l.modulo ASC";
        $result2 = $con->MRQ($consulta);



        return [
            "acciones" => $result1,
            "modulos" => $result2
        ];
    }
    
    
}
