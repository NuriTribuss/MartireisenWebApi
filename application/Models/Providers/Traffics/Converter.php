<?php

namespace Model\Providers\Traffics;

class Converter {

    function __construct() {
        
    }
    
    public function region($result) {
      //  var_dump($result);
        
        $data = [];
        $top  = [];
        
        foreach($result->superRegionList as $key => $region) {
            
            $data[$key] = [
                'code'          => $region->code,
                'name'          => $region->name,
                'price'         => $region->bestPricePerPerson->value,
                'children'      => []
            ];
            
            foreach($region->regionList as $subKey => $childRegion) {
                
                 $data[$key]['children'][$subKey] = [
                    'code'          => $childRegion->code,
                    'name'          => $childRegion->name,
                    'price'         => $childRegion->bestPricePerPerson->value,
                    'temp'          => [
                        'water'     => $childRegion->climateData->waterTemperature,
                        'air'       => $childRegion->climateData->maxAirTemperature,
                    ],
                    'flight'   => [
                        'estimatedTime' =>  $childRegion->climateData->estimatedFlightTime
                    ]
                 ];
            }
            
            // TOP
            
            if($region->code == "724"){
                $top[] = $data[$key];
            }
        }
        
        $return = ['top' => $top , 'data' => $data , 'raw' => $result];
        return $return;
    }
    
    public function hotel($result) {
        $data = [];
        
        foreach($result->hotelList as $key => $hotel) {
            
            $hotel->name_sef = \Helper\Url::beautify($hotel->name);
            $hotel->overall_rate = 0;
            if($hotel->rating != null){
                $hotel->overall_rate = $hotel->rating->overall;
            }
            $data[] = $hotel;
            
        }
        $data = \array_filter($data, static function ($hotel) {
            return $hotel->giata->hotelId > 0;
        });
        $result->hotelList = $data;
        return $result;
    }
    public function offer($result){
        $result->commonOffer->hotelOffer->hotel->name_sef = \Helper\Url::beautify($result->commonOffer->hotelOffer->hotel->name);
        return $result;
    }

    public function completion($result){
        return $result;
    }
}