<?php

namespace Application\Service\Engine;

use Core\Base\Service;

class Statics extends Service {
            
    
    function __construct() {
        parent::__construct();
    }
    
    public function facility() {
        
        $content = file_get_contents(PATH.'/public/facility.json');
        die($content);
    }
   
}
