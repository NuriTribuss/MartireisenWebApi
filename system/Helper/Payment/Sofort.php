<?php

namespace Helper\Payment;

use Sofort\SofortLib\Sofortueberweisung;
use Sofort\SofortLib\Notification;
use Sofort\SofortLib\TransactionData;

class Sofort {
    
    private $configKey = '';
    public $successStatus = ['untraceable','received'];
    
    public function __construct() {
        $this->configKey = \Helper\Config::get('USER_ID').':'.\Helper\Config::get('PROJECT_ID').':'.\Helper\Config::get('API_KEY');
    }
    
    public function checkout($amount,$bookingCode,$ref) {
        
        $return = array(
            'status' => false,
            'data'   => '',
            'url'    => ''
        );
        
        $url = 'https://www.martireisen.at';

        $Sofortueberweisung = new Sofortueberweisung($this->configKey);
        $Sofortueberweisung->setAmount($amount);
        $Sofortueberweisung->setCurrencyCode('EUR');
        $Sofortueberweisung->setReason($bookingCode, 'Verwendungszweck');
        $Sofortueberweisung->setSuccessUrl($url.'/service/booking/process', true); 
        $Sofortueberweisung->setAbortUrl($url.'/booking/checkout?code='.$ref);
        
        $Sofortueberweisung->sendRequest();
        
        if($Sofortueberweisung->isError()) {
            $return['data'] = $Sofortueberweisung->getError();
        } else {
            $transactionId = $Sofortueberweisung->getTransactionId();
            $paymentUrl    = $Sofortueberweisung->getPaymentUrl();
            $return['status'] = true;
            $return['data'] = $transactionId;
            $return['url']  = $paymentUrl;
        }
        
        return $return;
    }
    
    public function checkTransaction($transactionId = 0) {
        
        if(empty($transactionId)){
            return false;
        }
        
        $transaction = new TransactionData($this->configKey);
        $transaction->addTransaction($transactionId);
        $transaction->setApiVersion('2.0');
        $transaction->sendRequest();
        
        $k = $transaction->getResponse();
        
        $xml =  \Sofort\SofortLib\Xml\ArrayToXml::render($k);
        file_put_contents(PATH.'/data/log/payment/sofort_'.$transactionId.'.txt', $xml); 
       // echo $ar;
        
        if($transaction->isError()) {
            return false;
        } else {
            return $transaction->getStatus();
        }

    }
    
    // todo
    
    // notification
}
    