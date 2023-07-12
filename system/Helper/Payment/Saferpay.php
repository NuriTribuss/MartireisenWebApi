<?php

namespace Helper\Payment;

class Saferpay {
    
    private $customerId   = "";
    private $TerminalId   = "";
    private $testUrl      = "https://test.saferpay.com/api/";
    private $Url          = "https://www.saferpay.com/api/";
    private $iframePayUrl = "Payment/v1/PaymentPage/Initialize";
    
    public $Username      = "";
    public $Pass          = "";
    
    // public test account 
    public $testUsername  = "API_265940_69296188";
    public $testPass      = "JsonApiPwd1_rV)2E8C2W4up";
    public $testCustomer  = "265940";
    public $testTerminal  = "17755631";
    public $isTest        = 1;
    
    public function __construct() {
        
        $this->isTest     = \Helper\Config::get('TEST_MODE') == 1;
        
        $this->Username   = $this->isTest ? $this->testUsername : \Helper\Config::get('SAFERPAY_USERNAME');
        $this->Pass       = $this->isTest ? $this->testPass : \Helper\Config::get('SAFERPAY_PASSWORD');
        $this->Url        = $this->isTest ? $this->testUrl  : $this->Url;
        
        $this->TerminalId = $this->isTest ? $this->testTerminal  : \Helper\Config::get('SAFERPAY_TERMINAL');
        $this->customerId = $this->isTest ? $this->testCustomer  : \Helper\Config::get('SAFERPAY_CUSTOMER');
    }
    
    public function checkout($amount,$booking,$ref) {
        
        $return = array(
            'status' => false,
            'data'   => '',
            'url'    => ''
        );
        
        $payload = array(
            'RequestHeader' => $this->getHeader(),
            'TerminalId'    => $this->TerminalId,
            'ReturnUrls'    => $this->getCallbackUrl($ref,$booking),
            'Payment' => array(
                'Amount' => array(
                    'Value' => floatVal($amount),
                    'CurrencyCode' => 'EUR',
                ),
                'OrderId' => $booking,
                'Description' => $booking
            ),
        );
        
        try {
            
            $client = new \GuzzleHttp\Client();

            $response = $client->post($this->Url . $this->iframePayUrl, [
                'auth' => [
                    $this->Username,
                    $this->Pass
                ],
                'headers' => [
                    'Accept' => 'application/json; charset=utf-8',
                    'Content-type' => 'application/json',
                ],
                'body' => json_encode($payload),
            ]);

            $response = \GuzzleHttp\json_decode($response->getBody());
            $return['status'] = true;
            $return['url']    = $response->RedirectUrl;
            $return['data']   = $response->Token;
            
            
        }catch(\GuzzleHttp\Exception\ClientException $e){
            $response = \GuzzleHttp\json_decode($e->getResponse()->getBody());
            $return['data'] =  $response->ErrorMessage.' - '.$response->ErrorName;
        }
        
        return $return;
      
    }
    
    public function checkTransaction($transaction) {
        
        $return = array(
            'status' => false,
            'data'   => '',
            'url'    => ''
        );
        
        $payload = array(
            'RequestHeader' => $this->getHeader(),
            'Token'         => $transaction,
        );
        
        try {
            
            $client = new \GuzzleHttp\Client();
            $response = $client->post($this->Url .'/Payment/v1/PaymentPage/Assert', [
                'auth' => [
                    $this->Username,
                    $this->Pass
                ],
                'headers' => [
                    'Accept'        => 'application/json; charset=utf-8',
                    'Content-type'  => 'application/json',
                ],
                'body' => json_encode($payload),
            ]);

            $response = \GuzzleHttp\json_decode($response->getBody());
            $return['status'] = true;
            $return['data']   = $response->Transaction->Status;
            
            
        }catch(\GuzzleHttp\Exception\ClientException $e){
            $response = \GuzzleHttp\json_decode($e->getResponse()->getBody());
            $return['data'] =  $response->ErrorMessage.' - '.$response->ErrorName;
        }
        
        return $return;
        
    }
    
    public function getHeader() {

        $arr = array(
            'SpecVersion' => "1.10",
            'CustomerId' => $this->customerId,
            'RequestId' => uniqid(),
            'RetryIndicator' => 0,
            'ClientInfo' => array(
                'ShopInfo' => "Martireisen",
                'OsInfo' => "Test"
            )
        );
        
        return $arr;
    }
    
    public function getCallbackUrl($ref,$code) {
        
        $url = 'https://www.martireisen.at';

        $arr = array(
            "Success" =>  'https://webapi.martireisen.at/service/booking/process?code='.$code,
            "Fail"    =>  $url.'/booking/checkout?code='.$ref
            //Fail" =>  'http://localhost/MartireisenWebApi/booking/checkout?code='.$ref

        );
        
        return $arr;
        
    }

}
    
  /**

class saferpay
{
  


    private $directPayUrl = "Payment/v1/Transaction/AuthorizeDirect";
    private $iframePayUrl =  "Payment/v1/PaymentPage/Initialize";
    private $threeDPayUrl =  "Payment/v1/Transaction/Initialize";

    public $PaymentMethods = array("DIRECTDEBIT","VISA");

    public $PayerEmail = "payer@martireisen.at";
    private $MerchantEmail = "merchant@martireisen.at";
    private $NotifyUrl = "https://v5.martireisen.at/search/callback";

  
    function index()
    {
        try {
            $payload = array(
                
                //'PaymentMethods' => array("MASTERCARD", "VISA"),
                
                'PaymentMeans' => [
                    'Card' => [
                        'Number' => $this->cardNumber,
                        'ExpYear' => $this->cardYear,
                        'ExpMonth' => $this->cardMonth,
                        'HolderName' => $this->cardName,
                        'VerificationCode' => $this->cardCvc
                    ]
                ],
                'Payer' => array(
                    'IpAddress' => $this->IpAddress,
                    'LanguageCode' => $this->LanguageCode
                ),
               
                'Notification' => array(
                    'PayerEmail' => $this->PayerEmail,
                    'MerchantEmail' => $this->MerchantEmail,
                    'NotifyUrl' => $this->NotifyUrl
                ),
                'DeliveryAddressForm' => array(
                    'Display' => true,
                    'MandatoryFields' => []
                )
            );

            $client = new Client();

    }


}
   * 
   */