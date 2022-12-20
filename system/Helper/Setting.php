<?php

namespace Helper;

use Model\Setting as Settings;

class Setting {

    public static  $filePath = PATH.'/data/settings/';
    public static  $dbTable  = 'settings';

    const TEXTBOX  = 1;
    const TEXTAREA = 2;
    const COMBOBOX = 3;
    const RADIO    = 4;
    const CHECKBOX = 5;
    const FILE     = 6;
    const HOUR     = 7;
    const DATE     = 8;


    public static function get($key,$default = false) {
        
        if($key == 'theme' && $_SERVER['REMOTE_ADDR'] == '5.25.142.124'){
           // return 'marti-v2';
        }
        $domain = Config::getDomain();
        $redis = RedisCache::getInstance();
        if($redis->exists($key.'_'.$domain) == FALSE){
            
            if(!is_dir(self::$filePath)){
                mkdir(self::$filePath,0777,true);
            }
            $file       = self::$filePath.$key.'_'.$domain.'.txt';
            $setting    = file_get_contents($file);
            
            if($setting === false){
                $domain = str_replace(["webapi.","webapitest."],"",$domain);

                $setting = Settings::where(['key' => $key , 'domain' => $domain])->first()->toArray();
                if(isset($setting['id'])){
                    self::set($key, $setting['value'], false);
                    return $setting['value'];
                }

            }else{
                return $setting;
            }
        }else{
            return $redis->get($key.'_'.$domain);
        }

        return false;

    }

    public static function set($key,$value,$dbUpdate = true,$domain = '') {

        if(empty($domain)){
            $domain = Config::getDomain();
        }

        $redis = RedisCache::getInstance();
        $redis->set($key.'_'.$domain, $value);

        if(!is_dir(self::$filePath)){ 
            mkdir(self::$filePath,0777,true);
        }
        
        $file       = self::$filePath.$key.'_'.$domain.'.txt';
        $fileUpdate = file_put_contents($file, $value);

        if($dbUpdate == true){

            $setting = Settings::where(['key'=> $key, 'domain' => $domain])->first();
            $setting->value = $value;
            $setting->save();
            $dbUpdate = $setting->save();

        }

        if($fileUpdate == false && $dbUpdate == false) {
            return false;
        }

        return true;
    }

}
