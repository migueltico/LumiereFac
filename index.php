<?php
// $expire=15*60*60;
// session_set_cookie_params($expire);
// server should keep session data for AT LEAST 30 hour
ini_set('session.gc_maxlifetime', 92000);
set_time_limit(1300);
ini_set('memory_limit', '3072M');
if ($_SERVER['SERVER_NAME'] == "soporte-lumiere.com") {
    set_include_path('/var/www/soporte');
} else {
    set_include_path('/var/www/lumiere');
}
// each client should remember their session id for EXACTLY 30 hour
session_set_cookie_params(92000);
session_start();

//error_reporting(E_ALL);
date_default_timezone_set('America/Costa_Rica');
require 'config/config.php';
require_once 'vendor/autoload.php';
//require_once 'config/autoload.php';
//Config\Autoload::on();
$err = new config\Config;
$err->route();
$err->err();
