<?php namespace middleware;
 use config\helper as h;
class loginMiddleware
{
    public function auth($request = '', $next = '')
    {
     
      
        if (!isset($_SESSION['id'])) {
            if($_SERVER['REQUEST_URI']!=="/"){
                h::redirect("/");
            }           
            return true;
        }else{
            if($_SERVER['REQUEST_URI']=="/"){
                h::redirect("/dashboard");
            }
            return true;
        }
    }
  
}