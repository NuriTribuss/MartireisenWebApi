<?php

namespace Model\Entities;

class Region {

    function __construct() {
        
    }
    
    public function __set($name, $value) {
        $this->{$name} = $value ;
    }

}