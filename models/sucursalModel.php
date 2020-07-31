<?php namespace models;
 use Config\helper as h;
use config\conexion;
class sucursalModel
{
    /**
     * obtiene todas las sucursales
     *
     * @return void
     */
    public static function getSucursal()
    {
        $con = new conexion();
      
        return $con->SQND('SELECT * FROM sucursal');
    }

     /**
     * obtiene todos los productos
     *
     * @return void
     */
    public static function setSucursal($sucursal)
    {
        $con = new conexion();
        return $con->SPCALLR("CALL sp_insert_sucursal()",$sucursal);
    }
}