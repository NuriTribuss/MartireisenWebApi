<?php

namespace Model;

class BookingView {
    
    public function __construct() {
        
    }
    
    /*
     *  TRAVEL IT DATA MAPPING
     * 
     */
    public function get($data) {
        
        $arr = array(
            'type'    => $data['SF'],
            'hotel_info' => array(
                'id'   => $data['SERVICE']['ACCOMMODATION']['GID'],
                'name' => (string)$data['SERVICE']['ACCOMMODATION']['HOTELNAMEGIATA'],
                'star' => (int)$data['SERVICE']['ACCOMMODATION']['KATGIATA'],
                'city' => array(
                    'name' => (string)$data['SERVICE']['ACCOMMODATION']['ZIEL'],
                ),
            ),
            'transport' => array(
                'bus'   => (int)$data['SERVICE']['INCLUDING']['TRANS'],
                'train' => (int)$data['SERVICE']['INCLUDING']['RAIL']
            ),
            'operator'  => array(
                'code'  => $data['SERVICE']['VERANST'],
                'name'  => $data['SERVICE']['VERANST']
            ),
            'price_display'  => number_format($data['SERVICE']['GPREIS'],2,',','.'),
            'price_base'     => number_format($data['SERVICE']['GPREIS'],2,',','.'),
            'price'          => $data['SERVICE']['GPREIS'],
            'discount'       => 0,
            'currency'       => $data['SERVICE']['WKZ'],
            'start_date'     => $data['SERVICE']['TERMIN'],
            'end_date'       => $data['SERVICE']['RRTAG'],
            'day'            => $data['SERVICE']['TAGE'],
            'person_count'   => $data['SERVICE']['PERSONS'],
            'room_type'      => $data['SERVICE']['ACCOMMODATION']['ZT'],
            'board'          => $data['SERVICE']['ACCOMMODATION']['VT'],
            'person_count'   => $data['SERVICE']['PERSONS'],
            'reise_art'      => $data['SERVICE']['REISEART'],
            'departure_name' => $data['SERVICE']['APTA'],
            'raw'            => $data['SERVICE'] 
           
        );
        
        $arr = array_merge($arr,$data);
        return $arr;
    }
}