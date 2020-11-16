<?php

namespace config;

$archivo = "./env.ini";

$contenido = parse_ini_file($archivo, true);
$env = $contenido['env'];
// print_r($contenido['env']);
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
if ($env == 1) {
    $DB_NAME = array(
        "alajuela" => "id14989780_lumiere",
        "heredia" => "BDA_HEREDIA",
        "sanjose" => "BDA_SAN_JOSE",
    );
} else {
    $DB_NAME = array(
        "test" => "maindb"
    );
}


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
