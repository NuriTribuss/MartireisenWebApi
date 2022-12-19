<?php

namespace Core;

use Model\Link;
use Illuminate\Database\Capsule\Manager as DB;

class App {

    public static $type  = 'admin';
    public static $linkData = NULL;
    public static $setting;
    public static $route = '';
    public static $routeArr = array();
    public static $domains  = [];
    public $redis;
    public $db;

    public function __construct($debug = false) {

        if($debug){
            \Helper\Config::debug();
        }
        
        $this->redis   = new \Helper\RedisCache();
    }

    public static function setType($type){
        self::$type = $type;
    }

    public static function getType(){
        return self::$type;
    }

    public function start() {
        
        self::$setting = new \Helper\Setting();

        \Core\Session\Session::init();
        new Database\Database();
        
        $this->initDomains();
        $this->route();
    }

    public function route() {
        
        $uri     = ltrim(\Helper\Input::get('params',''),'/');
        
        $lastEl = substr($uri, -1);
        if($lastEl == '/'){
            $uri = rtrim($uri,'/');
        }
        $link   = new Link;
        if(empty($uri)){
            $record = $link->getHome();
        }else {
            $record = $link->findByValue( ($uri));
        }
        
        
        if($record != NULL && isset($record['route'])){
            
            $uri        = $record['route'];
            
            $record     = $link->getAlternates($record);
            self::$linkData = $record;
            
            $this->initRobotParams($record);
            
            // baska sınıfa alınacak
            if(strpos($_SERVER['HTTP_REFERER'],'service') === false) {
                \Model\User\Customer::setLanguage($record['locale']);
            }            
        }
        
        if(!empty($record['redirect_value'])){
            Http\Redirect::go($record['redirect_value']);
        }
        
        self::$route = $uri;        
        $routing = new \Core\Routing($uri);
        $run     = $routing->execute();  
        if($run === false) {
            $uri = 'not-found/index';
            $routing = new \Core\Routing($uri);
            $run     = $routing->execute();
        }
    }
    
    /*
     *  Sistemde tanımlı domainleri redise dolduruyoruz
     */
    
    public function initDomains() {
        
        $domains = $this->redis->get('domains');

        if($domains == false) {
            $domains = \Model\Sys\Domain::get()->toArray();
            $domains = json_encode($domains);
            $this->redis->set('domains', $domains);
        }
        
        $domains = json_decode($domains,true);
        self::$domains = $domains;
    }
    
    /*
     *  Default olmayan domainlerde sadece içerik sayfalarını google sonuçlarında listeletiyoruz 
     */
    
    public function initRobotParams($record) {
        
        $currentDomain = \Helper\Config::getDomain();
        $domains = self::$domains;
        
        foreach($domains as $d){
            
            if($d['name'] != $currentDomain) {
                continue;
            }
            if($d['is_default'] != 1 && $record['route'] != 'index/index' && $record['type'] != 'content/page'){
                header("X-Robots-Tag: noindex, nofollow", true);
            }
        }
    }

    public function __destruct() {
        
        $logs = DB::getQueryLog();

        if($_SERVER['REMOTE_ADDR'] == '231.206.81.36') {
              echo PHP_EOL;
            echo count($logs).' Sorgu '.PHP_EOL;
            echo '<table class="table table-responsive"><thead><th><td>Query</td><td>Time</td><td>Bind</td></th></thead><tbody>';
            
          
            foreach($logs as $l){
                echo '<tr><td>'.$l['query'].'</td><td>'.$l['time'].' </td><td> '.json_encode($l['bindings']).'</td></tr>';
            }
            echo '</tbody><table>';
        }
        
        $this->redis->close();
    }
}