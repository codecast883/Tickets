<?php

//ini_set('display_errors', 1);
//error_reporting(1);


define('DOMAIN', $_SERVER['SERVER_NAME']);

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
// define('DOMAIN', $_SERVER['SERVER_NAME']);

define('DB_SERVER', '192.168.1.59');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tickets');
