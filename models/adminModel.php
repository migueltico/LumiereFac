<?php

namespace models;

use Config\helper as h;
use config\conexion;

class adminModel
{
    /**
     * Obtiene el usuario que coincida con los datos proporcionados
     *
     * @param string $user
     * @param string $pass
     * @return void
     */
    public static function getGastos()
    {
        $con = new conexion();
        return $con->SQR_ONEROW('
        SELECT g.gastos, g.total, g.efectivo, g.tarjeta, g.transferencia, g.modificado_por, DATE_FORMAT(g.fecha_ingresos,"%m-%Y") AS mes, u.nombre, u.usuario, g.modificado_el AS fecha
        FROM gastos AS g
        INNER JOIN usuario AS u ON u.idusuario = g.modificado_por
        WHERE g.idgastos=1');
    }
    public static function setGastos($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_addGastos(:gastos,:total,:iduser)', $datos);
    }
    public static function getCategoriaPrecios()
    {
        $con = new conexion();
        return $con->SPCALL('CALL sp_getCategoriaPrecios()');
    }
    public static function AddCategoriaPrecios($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_addCategoriasPrecios(:descripcion,:factor,:iduser)', $datos);
    }
    public static function EditCategoriaPrecios($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_EditCategoriasPrecios(:descripcion,:factor,:iduser,:id)', $datos);
    }
    public static function DeleteCategoriaPrecios($datos)
    {
        $con = new conexion();
        return $con->SQ('DELETE FROM categoria_precios WHERE idCategoriaPrecio = :id', $datos);
    }
    /**
     * Guarda la accion generada por el usuario
     *
     * @param string $accion Generada
     * @param string $modulo Modulo donde se genero la accion
     * @param string $detalle Detalle de la accion
     * @param string $datos Datos en formato json
     * @param string $idusuario Usuario
     * @return void
     */
    public static function saveLog($accion, $modulo, $detalle, $datos, $idusuario)
    {
        $con = new conexion();
        $datos = array(
            ':accion' => $accion,
            ':modulo' => $modulo,
            ':detalle' => $detalle,
            ':datos' => $datos,
            ':idusuario' => $idusuario
        );
        return $con->SQ('CALL sp_saveLog(:accion,:modulo,:detalle,:datos,:idusuario)', $datos);
    }
}
