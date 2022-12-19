<?php

namespace Model;

class HotelView {
    
    public function __construct() {
        
    }
    
    public function get($data,$secondary = null) {
        
        $data = json_decode(json_encode($data),true);
        $arr = array(
            'info' => array(
                'id'   => $data['giata']['hotelId'],
                'name' => (string)$data['giata']['hotelName'],
               // 'description' => (string)$data['giataHotel']['description'],
                'description' => $data['catalogData']['html'],
                'star' => (int)$data['category'],
                'city' => array(
                    'code' => (string)$data['location']['code'],
                    'name' => (string)$data['location']['name']
                ),
                'country' => array(
                    'code' => (string)$data['location']['region']['code'],
                    'name' => (string)$data['location']['region']['name'],
                    
                ),
            ),
            'operator' => array(
                'name' => $data['tourOperator']['name'],
                'code' => $data['tourOperator']['code'],
                'logo' => $data['tourOperator']['logo']
            ),
            'reviews' => array(
                'url'  => $data['reviews']['holidayCheckReviews']['url'],
                'id'   => $data['rating']['hotelId'],
                'review_count' =>(int)  $data['rating']['count'],
                'suggests' => (int)  $data['rating']['recommendation'],
                'average' => number_format($data['rating']['overall'],1,'.',''),
            ),
           // 'images' => (array)$data['giataHotel']['pictures'],
            'images' => $this->getGiataPic($secondary),
            'location' => array(
                'latitude' => $data['location']['latitude'],
                'longitude'=> $data['location']['longitude']
            ),
            'climate' => $this->getClimate($data['giataHotel']['climate']),
        );
        if(count($arr['images']) == 0){
            $arr['images']  = [['url' => 'https://thumbnails.travel-it.com/g2thmb.php?gid='.$arr['info']['id']]];
        }
        return $arr;
    }
    
    public function getClimate($climate) {
        if($climate == null){
            return [];
        }
        $return = [];
        $keys = array_keys($climate);
        foreach($keys as $k){
            if($k == 'referenceId'){
                continue;
            }
            
            $return[$k] = explode(',', $climate[$k]);
        }
        return $return;
    }
    
    public function getGiataPic($data) {
        
        $hotel  =  $data['response']->hotel;
        if($hotel == null){
            return [];
        }
        $list = $hotel->catalogData->imageList;
        $return = [];
        
        foreach($list as $l){
            $return[] = [
                'type' => 'A',
                'thumb' => str_replace('size=180','size=800',$l),
                'url'   => str_replace('size=180','size=800',$l),
                'name' => 'A',
                'width' => 800
            ];
        }

        return $return;
    }
}