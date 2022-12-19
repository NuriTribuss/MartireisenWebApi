<?php

namespace Model\Api;

use GuzzleHttp\Client;

class Hotel {
    
    private $client;
    
    public function __construct() {
        $this->client = new Client();
    }
    
    
    public function get($gid,$goc,$vc = '1',$tab = 'all') {
        
        $url  = 'https://hic3.travel-it.com/hotelinfocenter3-backend/rest/hotel?';
      
        
        $opts = array(
            'cfg' => \Helper\Config::get('TRAVELIT_CFG'),
            'gid' => $gid,
            'oc'  => $goc,
            'tab' => $tab,
            'vc'  => $vc,
            'lang'=> \Core\Translation\Language::getLanguage()
        );
        
        $endPoint = $url.http_build_query($opts);
      //  var_dump($endPoint);
        try {
            $response     = $this->client->get($endPoint);
            $result       = $response->getBody();
            $hotel       = \GuzzleHttp\json_decode($result,true);
            $t = $this->getGiata($gid,$hotel['tourOperator']['code']);
            $hotel['giata'] = $t['data'];
            return $hotel;
            
        }catch(\Exception $e){
            return $e->getMessage();
        }    
    }
    
    public function getGiata($gid,$vc = '1') {
       
        $url  = 'https://xml.giatamedia.com/?';
        
        $opts = array(
            'sc' => 'hotel',
            'gid' => $gid,
            'vc'  => $vc,
            'lang'=> \Core\Translation\Language::getLanguage(),
            'show' => 'gid,hn,pic800,text
'
        );
        
        $endPoint = $url.http_build_query($opts);
        try {
            $response     = $this->client->get($endPoint, [
                'auth' => [
                    \Helper\Config::get('GIATA_USERNAME'),
                    \Helper\Config::get('GIATA_PASSWORD'),
                ]
            ]);
            $result       = $response->getBody();
            $json         = json_encode(simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA)); 
            $hotel        = json_decode($json,true);
            return $hotel;
            
        }catch(\Exception $e){
            return $e->getMessage();
        }    
        
    }
}   
