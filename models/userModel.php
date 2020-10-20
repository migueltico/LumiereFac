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
        return $con->SRQ('SELECT * FROM  usuario  WHERE usuario = :usuario AND password = :pass', $datos);
    }
}
