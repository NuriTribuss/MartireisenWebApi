<?php

namespace Model;

use Model\Booking\Travellers;
use Model\Booking\Transports;
use Model\Booking\PaymentMethodTranslation;

class BookingDetailView {
    
    public function __construct() {
        
    }
    
    
    public function get($data) {
        
        $travellers = Travellers::where('booking_code',$data['code'])->get();
        if($data['source'] == 'Traffics'){
            $apiData = $this->getApiData($data['ref']);
            $transports = $this->getTransportData($apiData);
        }else {
            $transports = Transports::where('booking_code',$data['code'])->get()->toArray();
        }
        
        foreach($transports as $key => $value){
            $transports[$key]['arr_date'] = date('d-m-Y',strtotime($value['arr_date']));
            $transports[$key]['dep_date'] = date('d-m-Y',strtotime($value['dep_date']));
        }
        
        $visitors = '';
        foreach($travellers as $index => $traveller){
            $visitors.= ($index+1). '. '. $traveller->name.' '.$traveller->surname.' <br>'; 
        }
        
        $arr = array(
            'travellers_block'   => $visitors,
            'hotel_image'        => $this->getImage($data),
            'code_link'          => \Helper\Config::get('SITE_URL').'/booking/complete/'.base64_encode($data['code'])
        );
        
        $arr['payment_name']    = $this->getPaymentName($data);
        $arr['transports']      = $transports; 
        $arr['traveller_phone'] = $data['phone'];
        if($data['source'] == 'Tour'){
            $tourView = new TourView();
            $tour = $tourView->get($data['tour_id']);
            if(!empty($tour['tour_plan_image'])){
                $tour['tour_plan_image'] =     'https://'.\Helper\Config::getDomain().'/'.$tour['tour_plan_image'];
            }
            $arr['tour'] = $tour;
        }
        $arr = array_merge($arr,$data);
        $arr['amount'] = number_format($arr['amount'], 2, ',', '');
        return $arr;
    }
    
    public function getPaymentName($data) {
        
        $data = PaymentMethodTranslation::where('payment_id',$data['payment_method'])->where('language',$data['language'])->first();
        if($data != null){
             return $data->title;   
        }
        return '';
    }
    
    public function getImage($data) {
        
        $image = '';
        
        switch($data['source']){
            
            case 'Tour':
                
                $tourView = new TourView();
                $tour = $tourView->get($data['tour_id']);
                $image = 'https://'.\Helper\Config::getDomain().'/'.$tour['image'];
                
                break;
           
            default : 
                $image = 'https://thumbnails.travel-it.com/g2thmb.php?gid='.$data['hotel_giata_code'];
                break;
        }
        
        return $image;
        
    }
    
    public function getApiData($ref) {
        
        $file = PATH.'/data/log/offer/'.$ref.'.txt';
        if(file_exists($file)){
            $offer = json_decode(file_get_contents($file),true);
        }else{
            $offer = null;
        }
        
        return $offer;
    }
    
    public function getTransportData($data) {
        
        $transports  = [];
        $flight      = $data['commonOffer']['flightOffer']['flight'];
        
        foreach($flight['outboundLegList'] as $leg){
            $transports[] = [
                'airline'  => $leg['flightCarrierName'],
                'dep_name' => $leg['departureAirportName'],
                'dep_date' => $leg['departureDate'],
                'dep_time' => $leg['departureTime'],
                'arr_time' => $leg['arrivalTime'],
                'arr_date' => $leg['arrivalDate'],
                'arr_name' => $leg['arrivalAirportName'],
                'arr_iata' => $leg['flightNumber'],
                'direction' => 'out',
            ];
        }
        
         foreach($flight['inboundLegList'] as $leg){
            $transports[] = [
                'airline'  => $leg['flightCarrierName'],
                'dep_name' => $leg['departureAirportName'],
                'dep_date' => $leg['departureDate'],
                'dep_time' => $leg['departureTime'],
                'arr_time' => $leg['arrivalTime'],
                'arr_date' => $leg['arrivalDate'],
                'arr_name' => $leg['arrivalAirportName'],
                'arr_iata' => $leg['flightNumber'],
                'direction' => 'in',
            ];
        }
        
        return $transports;
    }
}