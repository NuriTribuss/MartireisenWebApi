<?php

namespace Application\Api;

use Core\Base\Webservice;
use Model\Account as Model;
//use Model\Sys\User\Access;

class Account extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
        $record = Model::find($this->session->id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->setHidden(['password','passwordkey']);
        $this->response->setData($record->toArray())->setStatus(true)->out();
    }
    
    public function store() {
        echo __METHOD__;
    }
    
    public function update() {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'firstname' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($this->session->id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->firstname    = isset($data->firstname) ? $data->firstname : $record->firstname; 
        $record->lastname     = isset($data->lastname) ? $data->lastname : $record->lastname; 
        $record->website      = isset($data->website) ? $data->website : $record->website; 
        $record->mobile_phone = isset($data->mobile_phone) ? $data->mobile_phone : $record->mobile_phone; 
        
        $record->save();
        $this->response->setStatus(true)->out();
       
    }
    
    public function show($id = 0) {
        echo __METHOD__;
    }
    
    public function destroy($id = 0) {
        echo __METHOD__;
    }  
    
    public function password() {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'password_old'   => 'required',
            'password_new'   => 'required',
            'password_again' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($this->session->id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if($record->password != md5($data->password_old)){
             $this->response->setMessage('Current Password is invalid')->out();
        }
        
        if(($data->password_new) != ($data->password_again)){
             $this->response->setMessage('Passwords not exact')->out();
        }
        
        if(($record->password) == md5($data->password_new)){
             $this->response->setMessage('Your password not same as old password')->out();
        }
        
        $record->password = md5($data->password_new);
        $record->save();
        
        $this->response->setStatus(true)->out();
    }
    
    public function logs() {
        
        try{
             
            $data   = Access::where('user_id', $this->session->id)->skip(0)->take(5)->orderBy('id','desc')->get()->toArray();
            $this->response->setStatus(true)->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
}
