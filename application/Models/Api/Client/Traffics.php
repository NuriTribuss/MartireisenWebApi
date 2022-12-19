<?php

namespace Model\Api\Client;


class Traffics extends Api {

    private $url = 'https://connector.traffics.de/v3/rest/';
    private $headers;
    
    public function __construct() {
        $this->headers[] = "Authorization: ".$this->getApiKey();
    }
    
    public function searchHotel($query) {
        
        $url = $this->url.'completions';
        
        $payload = [
            'subTypeRegion'     => "true",
            'subTypeGiataHotel' => "true",
            'searchValue'       => $query,
            'limit'             => 40
        ];
        
        return $this->doGet($url, $payload, $this->headers);
        
    }
    
    
    private function doPost($url, $payload, $headers = array()) {
        
        
        $fields = array(
            "domain"     => $this->domain,
            "token"      => $this->apiKey,
            "payload"    => $payload,
        );
     
        $str = json_encode($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");

        if (count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
       
        return json_decode($response);
    }
    
    public function doGet($url,$payload,$headers) {
        
        $payload = http_build_query($payload);
        $url = $url.'?'.$payload;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");

        if (count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
       
        return json_decode($response);
    }
    
    public function getApiKey() {
        return base64_encode(\Helper\Config::get('TRAFFICS_USERNAME').':'.\Helper\Config::get('TRAFFICS_PASSWORD'));
    }
}
