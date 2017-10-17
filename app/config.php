<?php

//ini_set('display_errors', 0);
//error_reporting(0);


define('DOMAIN', $_SERVER['SERVER_NAME']);

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(E_ALL);
// define('DOMAIN', $_SERVER['SERVER_NAME']);

define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tickets');
