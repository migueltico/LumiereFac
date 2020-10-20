<?php

namespace models;

use config\helper as help;
use config\conexion;

class usuariosModel
{
    /**
     * Obtiene La lista de usuarios
     */
    public static function getUsers()
    {
        $con = new conexion();
        return $con->SQND("SELECT *, r.rol as roles FROM usuario as u INNER JOIN rol as r ON u.rol = r.idrol;");
    }
    /**
     * agrega usuario
     */
    public static function setUsers($datos)
    {
        $con = new conexion();
        return $con->SPCALLNR("CALL sp_insertUser()", $datos);
    }
    public static function getRols()
    {
        $con = new conexion();
        return $con->SQND("SELECT * FROM rol");
    }
}
