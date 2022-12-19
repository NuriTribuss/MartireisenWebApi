<?php

namespace Core\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database {

    function __construct() {

        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => \Helper\Config::get('HOST'),
            'database'  => \Helper\Config::get('DB'),
            'username'  => \Helper\Config::get('USER'),
            'password'  => \Helper\Config::get('PASS'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        
        $capsule->connection()->enableQueryLog();
    }
}