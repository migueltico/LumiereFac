<?php

namespace config;

// define('DS', DIRECTORY_SEPARATOR);
// define('ROOT', realpath(dirname(__FILE__)) . DS);
define('VIEWS', './views/');
define('TEMPLATE', './views/template/');
define('BLOCKS', './views/blocks/');
define('CONTENTS', './views/contents/');
define('ELEMENTS', './views/elements/');
define('MODALS', './views/modals/');
define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
define('DB_USER', 'root');
define('DB_PASS', '');
const DB_NAME = array(
    "alajuela" => "id14989780_lumiere",
    "testMain" => "maindb",
    "test" => "dbfac",
    "heredia" => "BDA_HEREDIA",
    "sanjose" => "BDA_SAN_JOSE",
);
//define('DB_NAME', 'dbfac');

$route_group = '';
$route_group_active = false;
$middleware_array = [];
$middleware_active = false;
$error404 = false;
$errorMsg = ["send_msg" => false, "data" => null, "url" => null];
date_default_timezone_set('America/Costa_Rica');

use config\view;

class Config
{

    public function err()
    {
        if (!$GLOBALS["error404"]) {
            if ($GLOBALS["errorMsg"]['send_msg']) {
                echo view::renderError($GLOBALS["errorMsg"]['url'], $GLOBALS["errorMsg"]['data']);
            } else {
                echo view::renderError('error404');
            }
        } else {
            $GLOBALS["error404"] = false;
            $GLOBALS["errorMsg"]['url'] = null;
            $GLOBALS["errorMsg"]['send_msg'] = false;
            $GLOBALS["errorMsg"]['data'] = null;
        }
    }
    public function route()
    {
        require_once "http/routes/rutas.php";
    }
}
