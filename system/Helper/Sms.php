<?php

namespace Helper;

class Sms {
    
    private $baseUri;
    private $username;
    private $password;
    
    public function __construct() {
        
        $this->baseUri  = Config::get('SMS_HOST');
        $this->username = Config::get('SMS_USERNAME');
        $this->password = Config::get('SMS_PASSWORD');
        
    }
    
    public function sendSms($phone,$message) {
        
        if(Config::get('SMS_ACTIVE') == 0){ 
            return false;     
        } 
         
        
        if(strlen($phone) < 7){
            return false;
        }
        
        $phone    = str_replace('+','',$phone);
        
        $data     = array(
            "recipientAddressList"  => [$phone],
            "contentCategory"       => "informational",
            "clientMessageId"       => uniqid(),
            "test"                  => "false",
            "messageContent"        => $message,
            "maxSmsPerMessage"      => 2
        );
        
        $endpoint = $this->baseUri.'/smsmessaging/text';
        $process  = curl_init();
        
        curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json' ,'Accept: application/json'));
        curl_setopt($process, CURLOPT_URL, $endpoint);
        curl_setopt($process, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($process, CURLOPT_TIMEOUT, 5);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        
        $return = curl_exec($process);
        curl_close($process);
        $result = json_decode($return);
       
        file_put_contents(PATH.'/data/logs/sms.log', $return.PHP_EOL,FILE_APPEND);
        
        if($result->statusCode !== 2000){
            return false;
        }        
        
        return true;
        
    }
}
