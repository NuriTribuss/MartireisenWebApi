<?php

namespace Core\Base;

use Core\Base\Controller;
use Core\Cache\DbCache;

class Service extends Controller{

    protected $dbCache;
    
    public function __construct($opts = array()) {
        
        \Core\App::setType('web');
        
        header_remove("Pragma"); 
        header("X-Robots-Tag: noindex, nofollow", true);
        
        $timeout = !empty($opts['max-age']) ? $opts['max-age'] : 1800;
        if($opts['cache']){
            header('Cache-Control: max-age='.$timeout.', public');
        }
        
        parent::__construct();       

        $this->dbCache = new DbCache();
        $this->dbCache->setTimeout(300);
    }
   
}
