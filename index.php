<?php 
ini_set("session.cookie_lifetime","86400");
ini_set("session.gc_maxlifetime","86400");
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
