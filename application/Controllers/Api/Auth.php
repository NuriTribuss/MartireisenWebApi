<?php

namespace Application\Api;

use Core\Base\Webservice;
use Model\Account;

class Auth extends Webservice{

    const AUTH = false;
    
    private $secretKey = '';

    public function __construct() {
        
        parent::__construct(self::AUTH);
        $this->secretKey = 'iggo_api'.md5(date('d').'-'.date('Y').'_M');
        
    }
    
    public function login() {
        
        $user = $_SERVER['PHP_AUTH_USER'];
        $pass = $_SERVER['PHP_AUTH_PW'];
        
        $data = \Helper\Input::json();
        
        if(!empty($data->username)){
            $user = $data->username;
            $pass = (string)$data->password;
        } 
           
        $find = Account::where('username',$user)->where('password',md5($pass))->first(['id','username','firstname','lastname','group','group_id']); 
        
        if($find == NULL){
            $this->response->http(401)->out();
        }
        
        \Core\Session\Session::set('auth', true);  
       
       /* $access = new \Model\Sys\User\Access();
        $access->user_id = $find->id;
        $access->username = $find->username;
        $access->ip = $_SERVER['REMOTE_ADDR'];
        $access->agent = $_SERVER['HTTP_USER_AGENT'];
        $access->save();*/
     
        $find = $find->toArray(); 
        $this->response->setStatus(true)->setSession($find)->setData(['token' => $this->setAuthorization($find) , 'session' => $find])->out();
    }
    
    public function user() {
        
        $data = new \stdClass();
        $data->token = trim(substr($_SERVER['HTTP_AUTHORIZATION'], 7));
        $this->token($data);
    }
    
    public function token($data = null) {
        
        $data =  $data == null ? \Helper\Input::json() : $data;
        if(empty($data->token)){
            $this->response->out();
        }
        
        try{

            $tokenObj =  $this->isValidToken($data->token);
            if($tokenObj == false){
                $this->response->setMessage('Invalid Token')->setData(null)->out();
            }
            
            $return = [ 'is_valid' => '0' , 'expire' => date('d.m.Y H:i:s',$tokenObj->exp) , 'expire_time' => $tokenObj->exp  , 'created_at' => date('d.m.Y H:i:s',$tokenObj->iat)];
            $find = Account::where('id',$tokenObj->data->id)->first(['id','username','firstname','lastname','group','group_id']);

            if($tokenObj->exp > time() && $find != NULL ){
                $return['is_valid'] = 1;
                $return['account'] = $find->toArray();
                $this->response->setStatus(true)->setData($return)->out();
            }
           
            if($find == NULL || $tokenObj->exp > time()){
                $this->response->http(401)->out();
            }
            
            $this->response->setData($return)->out();
        }catch(\Exception $e){
            $this->response->setMessage('Invalid Token')->setData(null)->out();
        }
        
    }
    
    // domain kontrolü
    public function register() {
        
        $secretKey   = \Helper\Input::post('secret_key','');
        $username    = \Helper\Input::post('username','');
        $password    = \Helper\Input::post('password','');
        
        if($secretKey != $this->secretKey || empty($username) || empty($password)){
            $this->response->setStatus(false)->out();
        }
        
        $record = Account::where(['username' => $username])->first();
        if($record != NULL){
            $this->response->setStatus(true)->setData(['id' => $record->id])->out();
        }
        
        $record              = new Account();
        $record->username    = $username;
        $record->password    = md5($password);
        $record->save();
        
        $this->response->setStatus(true)->setData(['id' => $record->id])->out();
    }

}