<?php
ob_start();
define('ROOT', dirname(__FILE__));
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use app\DB\Db;
use app\Components\Application; 




$dbo = new Db; 
$app = new Application;
$app->run();
