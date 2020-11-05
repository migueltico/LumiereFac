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
            return ["return" => true];
        } else {
            return ["return" => false,"send_json_error"=>true, "send_msg" =>false,"data"=>array("msg"=>"Necesitas tener una caja habilitada"),"url"=>"sincaja"];
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
