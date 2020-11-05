<?php

namespace middleware;

use config\helper as h;
use models\facturacionModel as fac;

class cajasMiddleware
{
    public function cajaAsignada($request = '', $next = '')
    {
        $data[":id"] = $_SESSION['id'];
        $data[":fecha"] = date('Y-m-d');;
        $result = fac::cajaAsignada($data);
        if ($result['rows'] > 0) {
            echo "nada";
            return false;
        } else {
            echo "Algo";
            return true;
        }



        // if (!isset($_SESSION['id'])) {
        //     if($_SERVER['REQUEST_URI']!=="/"){
        //         h::redirect("/");
        //     }           
        //     return true;
        // }else{
        //     if($_SERVER['REQUEST_URI']=="/"){
        //         h::redirect("/dashboard");
        //     }
        //     return true;
        // }
    }
}
