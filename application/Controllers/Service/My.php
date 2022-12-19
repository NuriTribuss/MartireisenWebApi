<?php

namespace Application\Service;

use Core\Base\Service;
use Model\Customer\Customer as Customer;
use Model\User\Customer as CustomerSession;

class My extends Service{

    public function __construct() {
        
        parent::__construct();
        if(!\Model\User\Customer::isLogged()){ 
            $this->response->out();
        }
    }
    
    public function get() {
        
        $id         = CustomerSession::getId();
        $account    = Customer::where('id',$id)->first(['gender','name','surname','address','country','city','town','phone','username','country_code']);
        $this->response->setData($account->toArray())->setStatus(true)->out();
    }
 
    
    public function changePassword() {

        $data = array(
            'password'          => \Helper\Input::post('password',''),
            'new_password'      => \Helper\Input::post('new_password',''),
            'new_password_a'    => \Helper\Input::post('new_password_a','')
        );
        

        if(empty($data['password']) || empty($data['new_password'])){
            $this->response->setStatus(false)->setMessage(_lang('user.required_field',true))->out();
        }

        if($data['new_password'] != $data['new_password_a']){
            $this->response->setStatus(false)->setMessage(_lang('user.password_match_error',true))->out();
        }

        $account = Customer::where('id', CustomerSession::getId())->where('password',md5($data['password']))->first();
        if($account != NULL){

            $account->password = md5($data['new_password']);
            $account->save();

            $mail = new \Model\Mail\Customer();
            $mail->sendPasswordChanged($account->username,$account->toArray());
            $this->response->setStatus(true)->setMessage(_lang('user.reset_password_successfull',true))->out();
        }else{
            $this->response->setStatus(false)->setMessage(_lang('user.passw_error',true))->out();
        }
    }
    
}
