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
     * UObtiene el usuario para crear contrasena nueva
     *
     * @param [type] $id Identificador
     * @return void
     */
    public static function validatePassRequest($id)
    {
        $con = new conexion();
        return $con->SQR_ONEROW("SELECT * FROM usuario WHERE identificador = '$id' AND estado = 2");
    }
    public static function GetIdentificador($id)
    {
        $con = new conexion();
        return $con->SQR_ONEROW("SELECT * FROM usuario WHERE idusuario = '$id' AND estado = 2");
    }
    public static function setPass($data)
    {
        $con = new conexion();
        return $con->SQ("UPDATE usuario SET password = :pass, identificador =NULL, estado = 1 WHERE idusuario = :id", $data);
    }
    /**
     * agrega usuario
     */
    public static function setUsers($datos)
    {
        $con = new conexion();
        return $con->SPCALLNR("CALL sp_insertUser(:usuario,:email,:nombre,:telefono,:direccion,:estado,:rol,:identificador)", $datos);
    }
    public static function getRols()
    {
        $con = new conexion();
        return $con->SQND("SELECT * FROM rol");
    }
}
