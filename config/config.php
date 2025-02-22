<?php

namespace config;

$archivo = "./env.ini";

$contenido = parse_ini_file($archivo, true);
$env = $contenido['env']['produccion'];
// print_r($contenido['env']);
// define('DS', DIRECTORY_SEPARATOR);
// define('ROOT', realpath(dirname(__FILE__)) . DS);
define('VIEWS', './views/');
define('TEMPLATE', './views/template/');
define('BLOCKS', './views/blocks/');
define('CONTENTS', './views/contents/');
define('ELEMENTS', './views/elements/');
define('MODALS', './views/modals/');
define('DB_HOST', 'db');
define('BACKUP_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/backups/');
// define('DB_USER', 'root');
define('DB_USER', 'root');
define('DB_PASS', '');
define('TESTPAGE', '');
$env_test = false;
if ($env == 1) {
    $DB_USER = "root";
    $DB_PASS = "1w25GuVZx@R2NESFJppiW3";
    $DB_NAME = array(
        "Alajuela" => "maindb",
        // "Heredia" => "herediadb",
        // "San Carlos" => "sancarlosdb",
        // "San Jose" => "sanjosedb",
        // "TestDB" => "testdb",
        // "TestDB2" => "testdb2",

    );
} else {
    $DB_USER = "root";
    $DB_PASS = "";
    $DB_NAME = array(
        "TestDB" => "maindb",
        "TestDB2" => "maindb"
    );
}


//define('DB_NAME', 'dbfac');

$route_group = '';
$route_group_active = false;
$middleware_array = [];
$middleware_active = false;
$error404 = false;
$errorMsg = ["send_msg" => false, "data" => null, "url" => null];

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
