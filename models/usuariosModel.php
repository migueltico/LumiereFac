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
    public static function editUser($datos)
    {
        $con = new conexion();
        return $con->SPCALLNR("UPDATE usuario SET  email = :email, nombre = :nombre, telefono = :telefono, direccion = :direccion, rol = :rol WHERE idusuario = :id", $datos);
    }
    public static function editUserPerfil($datos)
    {
        $con = new conexion();
        return $con->SPCALLNR("UPDATE usuario SET usuario = :usuario, email = :email, nombre = :nombre, telefono = :telefono, direccion = :direccion WHERE idusuario = :id", $datos);
    }
    public static function updatePass($datos)
    {
        $con = new conexion();
        return $con->SPCALLNR("UPDATE usuario SET password = :newpassword WHERE idusuario = :id", $datos);
    }
    /**
     * obtener usuario por ID
     */
    public static function getUserById($id)
    {
        $con = new conexion();
        return $con->SQR_ONEROW("SELECT * FROM usuario WHERE idusuario=$id");
    }
    public static function confirmPassNow($id)
    {
        $con = new conexion();
        return $con->SQR_ONEROW("SELECT password FROM usuario WHERE idusuario=$id");
    }
    public static function confirmUser($user)
    {
        $con = new conexion();
        return $con->SQR_ONEROW("SELECT * FROM usuario WHERE usuario='$user'");
    }
    public static function getRols()
    {
        $con = new conexion();
        return $con->SQND("SELECT * FROM rol");
    }
}
