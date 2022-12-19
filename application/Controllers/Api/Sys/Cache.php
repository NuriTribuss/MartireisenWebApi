<?php

namespace Application\Api\Sys;

use Core\Base\Webservice;
use Model\Setting;

class Cache extends Webservice {

    public function __construct() {
        parent::__construct();
    }
   
    public function clearSettings() {
        
        $settings = Setting::all();
        foreach($settings as $setting){
            \Helper\Setting::set($setting->key, $setting->value, false , $setting->domain);
        }
        
        $this->response->setStatus(true)->out();
    }
    
    public function clearCache() {
        
        $file = new \Core\Storage\File();
        $file->setPath(\Helper\Config::get('CACHE_DIR','/cache/'));
        $file->delete();
                
        $this->response->setStatus(true)->out();
        
    }
}
