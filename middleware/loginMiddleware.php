<?php

namespace middleware;

use config\helper as h;

class loginMiddleware
{
    public function auth($request = '', $next = '')
    {
        $url = $_SERVER['REQUEST_URI'];

        if (!isset($_SESSION['id'])) {
            if ($url !== "/") {
                h::redirect("/");
            }
            return ["return" => true, "send_json_error" => false, "send_msg" => false, "msg" => ""];
        } else {
            if ($url == "/") {
                h::redirect("/dashboard");
            }
            return ["return" => true, "send_json_error" => false, "send_msg" => false, "msg" => ""];
            
        }
    }
}
