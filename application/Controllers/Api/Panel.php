<?php

namespace Application\Api;

use Core\Base\Webservice;
use Helper\Setting;

class Panel extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function menu() {
        $group_id =  $this->session->group_id;
        $json = file_get_contents(PATH.'/resources/menu.json');
        if($group_id != 0 && file_exists(PATH.'/data/group/'.$group_id.'.json')){
         //   echo 'a';
             
            $json =  file_get_contents(PATH.'/data/group/'.$group_id.'.json');
        }
        $items = json_decode($json);

        $theme = Setting::get('theme');
        $themeJson = PATH.'/themes/web/'.$theme.'/config.json';
        if(!file_exists($themeJson)){
            echo $json;
            exit;
        }

        $themeObject = json_decode(file_get_contents($themeJson));

        $result = [];
        foreach($items as $item){
            if($item->custom == 1 && !in_array($item->key,$themeObject->modules)){
                continue;
            }

            $result[] = $item;
        }
        echo json_encode($result);
    }  

}
