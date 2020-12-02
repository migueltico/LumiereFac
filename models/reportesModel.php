<?php

namespace models;

use config\helper as h;
use config\conexion;

class reportesModel
{
    public static function getRols()
    {
        $con = new conexion();
        return $con->SQND("SELECT * FROM rol");
    }

}
