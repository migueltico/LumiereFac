<?php 
$expire=15*60*60;
session_set_cookie_params($expire);
session_start();
//error_reporting(E_ALL);
date_default_timezone_set('UTC');
require 'config/config.php';
require_once 'vendor/autoload.php';
//require_once 'config/autoload.php';
//Config\Autoload::on();
$err = new config\Config;
$err->route();
$err->err();
