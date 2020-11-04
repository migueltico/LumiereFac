<?php

namespace models;

use config\helper as h;
use config\conexion;

class rolesModel
{
    public static function getRols()
    {
        $con = new conexion();
        return $con->SQND("SELECT * FROM rol");
    }
    public static function setRol($data)
    {
        $con = new conexion();
        return $con->SQ("INSERT INTO rol (rol, descripcion,creado_por, modificado_por) VALUE (:rol,:descripcion,:creado_por,:modificado_por)", $data);
    }
    public static function setRolpermisos($data)
    {
        $con = new conexion();
        return $con->SQ("UPDATE rol SET permisos = :permisos, modificado_por = :modificado_por WHERE idrol = :idrol", $data);
    }
    public static function getRolesPermisos($data)
    {
        $con = new conexion();
        return $con->SRQ("SELECT permisos FROM rol WHERE idrol = :idrol",$data);
    }
}
