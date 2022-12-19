<?php

namespace Helper;

class Validation {
    
    private $errors = [];
    private $inputs = [];
    
    public function __construct() {
        $this->inputs  = Input::json();
    }
   
    public function validate($arr) {
        
        foreach($arr as $key => $el){
            $this->validateItem($key,$el);
        }
    }
    
    public function validateItem($key,$rules) {
        
        $ruleAll = explode('|', $rules);
        foreach($ruleAll as $rule){
            
            if($rule == 'required' && empty($this->inputs->{$key})){
                array_push($this->errors,['key' => $key , 'type' => 'required']);
            }
        }
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function hasError() {
        return count($this->errors) > 0;
    }
    
    public function reset() {
        $this->errors = [];
    }
}
?>