<?php

namespace models;

use config\helper as h;
use config\conexion;

class userModel
{
    /**
     * Obtiene el usuario que coincida con los datos proporcionados
     *
     * @param string $user
     * @param string $pass
     * @return void
     */
    public static function getUser($user = '', $pass = '')
    {
        $con = new conexion();
        $usuario = $user;
        $pass = $pass;
        $datos = array(
            ":usuario" => $usuario,
            ":pass" => $pass
        );
        return $con->SRQ('SELECT *, r.rol as rolname FROM usuario as u INNER JOIN rol as r on u.rol = r.idrol WHERE u.usuario = :usuario AND u.password = :pass', $datos);
    }
    /**
     * Obtiene el usuario que coincida con los datos proporcionados
     *
     * @param string $user
     * @param string $pass
     * @return void
     */
    public static function getUserById($id)
    {
        $con = new conexion();
        $datos = array(
            ":id" => $id
        );
        return $con->SRQ('SELECT *, r.rol as rolname FROM usuario as u INNER JOIN rol as r on u.rol = r.idrol WHERE u.idusuario = :id', $datos);
    }
    /**
     * Obtiene el usuario que coincida con los datos proporcionados
     *
     * @param string $user
     * @param string $pass
     * @return void
     */
    public static function getPermisos($idRol)
    {
        $con = new conexion();
        $datos = array(
            ":idrol" => $idRol
        );
        return $con->SRQ('SELECT permisos FROM rol WHERE idrol=:idrol', $datos);
    }
}
