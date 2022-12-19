<?php

namespace Model;

class HotelOffer {
    
    public function __construct() {
        
    }
    
    public function get($data) {
        
        $arr = array(
            'type'     => $data['SF'],
            'offers'   => array(),
            'review'   => (int) $data['BEWERTUNG'],
            'review_count'   => (int) $data['ANZBEWERTUNG'], 
            'suggests' => (int) $data['EMPFEHLUNGSRATE'],
            'hotel'    => array(
                'id'   => $data['GID'],
            ),
            
        );
        
        foreach($data['TERMIN'] as $offer){
            array_push($arr['offers'],  $this->getOffer($offer));
        }
        
        $arr['price'] = $arr['offers'][0]['price'];
        
        return $arr;
    }
    
    public function getOffer($offer) {
        
        $arr = array(
            'code'  => $offer['REF'],
            'price' => $offer['PREIS'],
            'total_price' => $offer['GPREIS'],
            'date'  => $offer['DATUM'],
            'return_date' => $offer['RRTAG'],
            'flight' => array(
              'checkin'  => $offer['HINFLUG'],
              'checkout' => $offer['RUECKFLUG']
            ),
            'airport'=> array(
                'name' => $offer['ABFLUG'],
                'code' => $offer['APTD']
            ),
            'airport_return'=> array(
                'name' => $offer['ANKUNFT'],
                'code' => $offer['APTDEST']
            ),
            'duration' => $offer['TAGE'],
            'room'     => $offer['ZT'],
            'meal'     => $offer['VT'],
            'transport'=> $offer['TRANS'],
            'operator' => $offer['VERANST'],
            'raw' => $offer
            
            
        );
        
        return $arr;
    }
}