<?php

/*
 *  MUSTAFA ERÇEL <mercelnet@gmail.com>
 *  01.01.2019
 *  Martireisen V5
 * 
 *
 *  Bu scripti izinsiz kullanmak yasaktır.
 */


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'); 

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type');
    header("HTTP/1.1 200 OK");
    die();
}

define('PATH',__DIR__);

require PATH.'/vendor/autoload.php';
require PATH.'/system/functions.php';
require PATH.'/system/bootstrap.php';
