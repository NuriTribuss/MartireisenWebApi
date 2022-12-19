<?php

namespace Helper;

class Validator {
    
    private $opts;
    private $fields;
    private $results;
    
    public function __construct() {
        
        $this->opts = array(
            'required'  => false,
            'max'       => 250,
            'min'       => 0,
        );
        
        $this->fields = array();
        
    }
    
    public function add($field,$opts = array()) {
        
        if(count($opts) <= 0){
            $opts = $this->opts;
        }
        
        $opts['key'] = $field['key'];
        $opts['key'] = $field['value'];
        
        array_push($this->fields, $opts);
        return $this;
        
    }
    
    public function run() {
        
        foreach($this->fields as $field){
            
            if(isset($field['required'])) {
                self::required($field['value']);
            }
            if(isset($field['max'])) {
                self::max($field['value'],$field['max']);
            }
            if(isset($field['min'])) {
                self::min($field['value'],$field['min']);
            }
        }
    }
    
    public static function required($str){
        return !(empty(trim($str)) || $str == NULL);
    }
    
    public static function max($value,$limit = 100000){
        
        if(is_numeric($value)){
            return $value <= $limit;
        }
        return strlen(trim($value)) <= $limit;
    }
    
    public static function min($value,$limit = 0 ){
        
        if(is_numeric($value)){
            return $value >= $limit;
        }
        return strlen(trim($value)) >= $limit;
    }
    
}