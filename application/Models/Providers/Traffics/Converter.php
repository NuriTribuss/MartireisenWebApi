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
            $data[] = $hotel;
            
        }
        
        $result->hotelList = $data;
        return $result;
    }
}