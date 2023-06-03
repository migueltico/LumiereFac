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
        try {
            //code...
            $con = new conexion();
            $datos = array(
                ":idrol" => $idRol
            );
            return $con->SRQ('SELECT permisos FROM rol WHERE idrol=:idrol', $datos);
        } catch (\Throwable $th) {
            //throw $th;
            return array("estado" => false, "error" => "Error con la Base de datos, por favor comuniquese con el encargado 2");
        }
    }
    public static function changePasswordUser($user, $pass, $db)
    {
        $con = new conexion($db);
        $datos = array(
            ":user" => $user,
            ":pass" => $pass
        );
        return $con->SRQ('UPDATE usuario SET password = :pass WHERE usuario = :user', $datos);
    }
}
