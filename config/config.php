<?php

namespace config;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('VIEWS', './views/');
define('TEMPLATE', './views/template/');
define('BLOCKS', './views/blocks/');
define('CONTENTS', './views/contents/');
define('ELEMENTS', './views/elements/');
define('MODALS', './views/modals/');
define('DB_NAME', 'dbfac');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
$route_group = '';
$route_group_active = false;
$middleware_array = [];
$middleware_active = false;
$error404 = false;
date_default_timezone_set('America/Costa_Rica');
class Config
{

    public function err()
    {
        if (!$GLOBALS["error404"]) {
            echo "<h1>ERROR404</h1>";
        } else {
            $GLOBALS["error404"] = false;
        }
    }
    public function route()
    {
        require_once "http/routes/rutas.php";
    }
}
