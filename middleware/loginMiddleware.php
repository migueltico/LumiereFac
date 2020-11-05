<?php

namespace middleware;

use config\helper as h;

class loginMiddleware
{
    public function auth($request = '', $next = '')
    {


        if (!isset($_SESSION['id'])) {
            if ($_SERVER['REQUEST_URI'] !== "/") {
                h::redirect("/");
            }
            return ["return" => false,"send_json_error"=>false, "send_msg" =>false,"msg"=>""];
        } else {
            if ($_SERVER['REQUEST_URI'] == "/") {
                h::redirect("/dashboard");
            }
            return ["return" => true,"send_json_error"=>false, "send_msg" =>false,"msg"=>""];
        }
    }
}
