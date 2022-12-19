<?php

namespace Model;

class HotelList {
    
    public function __construct() {
        
    }
    
    public function get($data) {
        $arr = array(
            'type'     => $data['SF'],
          //  'raw'      => $data,
            'hotels'   => array(),
            'cities'   => $data['ORTE']['ORT']
        );
        
        foreach($data['ANGEBOT'] as $hotel){
            array_push($arr['hotels'],  $this->getHotel($hotel));
        }
                
        return $arr;
    }
    
    public function getHotel($hotel) {
        
        $arr = array(
            'id'    => $hotel['GID'],
            'name'  => is_array($hotel['HOTELNAMEGIATA']) ? $hotel['HOTEL'] : $hotel['HOTELNAMEGIATA'],
            'name_giata' => $hotel['HOTELNAMEGIATA'],
            'name_operator' => $hotel['HOTEL'],
            'name_sef' => \Helper\Url::beautify($hotel['HOTEL']),
            'star'  => (int)$hotel['KAT'],
            'goc'  => $hotel['GOC'],
            'price' => $hotel['PREIS'],
            'base_price' =>  number_format($hotel['PREIS'] * (1.15),2,',',''),
            'date'  => $hotel['DATUM'],
            'duration' => $hotel['TAGE'],
            'room'     => (string)$hotel['ZT'],
            'meal'     => (string)$hotel['VT'],
            'transport'=> $hotel['TRANS'],
            'operator' => $hotel['VERANST'],
            'review'   => (float) $hotel['BEWERTUNG'],
            'review_id'=> $hotel['HCID'],
            'review_count' =>(int) $hotel['ANZBEWERTUNG'],
            'suggests' => (int) $hotel['EMPFEHLUNGSRATE'],
            'location'   => array(
                'city'      => (string)$hotel['HOTELORT'],
                'state'     => (string)$hotel['HOTELZIEL'],
                'country'   => (string)$hotel['HOTELREGION']
            ),
            'description' => $hotel['LSTG'],
            'image'       => 'https://thumbnails.travel-it.com/g2thmb.php?gid='.$hotel['GID'],
        );
        
        return $arr;
    }
}