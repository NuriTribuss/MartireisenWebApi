<?php

namespace Application\Api\Engine;

use Model\Providers\Connector;
use Model\Booking\Booking as BookingObj;
use Model\Booking\Travellers;
use Core\Base\Service;
use Model\Tour\Period;
use Model\TourView;

class Tour extends Service {
            
    private $connector;
    
    const BOOKING_PENDING = 0;
    const BOOKING_COMPLETED = 1;
    
    function __construct() {
        parent::__construct();
        $this->connector = new Connector();
    }
    
    public function create() {
        
        $data      = $this->check();
        $create    = $this->getBooking($data);          
       
        $booking   = new BookingObj;

        $booking->ref           =base64_encode($data['tour_id'].$data['personal']['email']);
        //$booking->ref           = $data['ref'];
        $booking->name          = $data['personal']['name'];
        $booking->surname       = $data['personal']['surname'];
        $booking->gender        = $data['personal']['gender'];

        $booking->phone         = $data['personal']['phone'];
        $booking->email         = $data['personal']['email'];
        $booking->birthday      = $data['personal']['birthday'];
        $booking->address       = $data['personal']['address'];
        $booking->country       = $data['personal']['country'];
        $booking->state         = $data['personal']['state'];
        $booking->city          = $data['personal']['city'];
        $booking->status        = self::BOOKING_PENDING;
        
        $booking->amount             = $create['amount'];
        $booking->currency           = $create['currency'];
        $booking->start              = $create['travel']['start'];
        $booking->end                = $create['travel']['end'];
        $booking->duration           = (int) $create['duration'];
        $booking->travel_city        = $create['travel']['city'];
        $booking->operator           = $create['operator'];
        $booking->hotel_giata_code   = $create['hotel']['giata'];
        $booking->hotel_name         = $create['hotel']['name'];
        $booking->payment_method     = $data['payment']['method'];
        $booking->adult_count        = count($data['traveller']);
        $booking->children_count     = count($data['children']);
       
        $booking->tour_id = $data['tour_id'];
        $booking->period_id = $data['period_id'];
        $booking->save();
        
        $booking->code        = 'M'.date('d').date('m').$booking->id;
        $booking->api_code    = '';
        $booking->source      = 'Tour';
        $booking->api_service = ''; //json_encode($create['service']);
        $booking->customer_id = 0;
        $booking->save();
        
        // Ulasım bilgileri

        // !!!!!!!!!!!!!!! ######### yapılacak...
      //  $this->setTransport($data['ref'],$booking->code);

        foreach($data['traveller'] as $traveller){
            
            $person = new Travellers();
            $person->booking_code   = $booking->code;
            $person->name           = $traveller['name'];
            $person->surname        = $traveller['surname'];
            $person->birthday       = $traveller['birthday'];
            $person->gender         = $traveller['gender'];
            $person->save();
        }
        
        foreach($data['children'] as $traveller){

            $person = new Travellers();
            $person->booking_code   = $booking->code;
            $person->name           = $traveller['name'];
            $person->surname        = $traveller['surname'];
            $person->birthday       = $traveller['birthday'];
            $person->gender         = $traveller['gender'];

            $person->is_children    = 1;
            $person->save();
        }
     
        if($data['payment']['method'] == 2){
            
            $sofort = new \Helper\Payment\Sofort();
            $return = $sofort->checkout(floatval($booking->amount),$booking->code,$booking->ref);
            if($return['status'] == false) {
                $booking->transaction_error = $return['data'];
                $booking->save();
            }else{
                $booking->transaction_id    = $return['data'];
                $booking->save();
                //\Core\Session\Session::set('payment_transaction', $return['data']);
                $this->response->setData($return)->setStatus(true)->out();
            }
            
        }else if($data['payment']['method'] == 3){
            
            $saferpay = new \Helper\Payment\Saferpay();
            $return = $saferpay->checkout(floatval($booking->amount*100),$booking->code,$booking->ref);

            if($return['status'] == false) {
                $booking->transaction_error = $return['data'];
                $booking->save();
            }else{
                $booking->transaction_id    = $return['data'];
                $booking->save();
                $this->response->setData($return)->setStatus(true)->out();
            }
        }else{
            /*
            $create     = $this->api->createBooking($data);
            if(isset($create['error'])){
                $this->response->setMessage(_lang('booking.unknown_error',true))->out();
            }
            if($create['response']->statusCode != 'OK' && $create['response']->statusCode !='NK'){
                $this->response->setMessage($create['response']->api_error)->out();
            }

            $booking->api_code = $create['response']->trafficsBookingCode;
            $booking->save();
            */
            try{
                $mail = new \Model\Mail\Customer();
                $mail->sendBookingRequested($data['personal']['email'], $booking->toArray());
            }catch(\Exception $e){
                
            }
            
        }
        
        $this->response->setData($booking->toArray())->setStatus(true)->out();
    }
    
    
    public function check(){
        
        $arr = json_decode(file_get_contents('php://input'), true);
        if($arr == NULL) {
            $this->response->setMessage('Invalid Request')->out();
        }
        if(empty($arr['tour_id'])) {
            $this->response->setMessage('Invalid Request [ref]')->out();
        }
        // ,'gender','birthday'
        $personalRequired = ['name','surname','phone','email','address','country','state','city'];
        $errors = [];
        
        foreach($personalRequired as $require){
            if(empty($arr['personal'][$require])){
                
                $errors[] = [
                    'key' => 'personal_'.$require,
                    'message' => _lang('booking.personal.e_'.$require,true),
                ];
            }
        }
        
        if(count($errors) > 0){
            $this->response->setData($errors)->out();
        }
        
        if(filter_var($arr['personal']['email'],FILTER_VALIDATE_EMAIL) == false) {
            $errors[] = [
                'key' => 'personal_email',
                'message' => _lang('booking.personal.e_email',true),
            ];
        }
        
        if(strlen($arr['personal']['phone']) <= 6) {
            $errors[] = [
                'key' => 'personal_phone',
                'message' => _lang('booking.personal.e_phone',true),
            ];
        }
        
        // ADULT CHECK
        if(count($arr['traveller']) == 0 ){
            $this->response->setMessage('Invalid Request')->out();
        }
        
        $required = ['name','surname','gender']; // birthday
        
        foreach($arr['traveller'] as $index => $traveller){
            foreach($required as $require){
                if(empty($traveller[$require])){
                    $errors[] = [
                        'key' => 'traveller'.$index.'_'.$require,
                        'message' => _lang('booking.traveller.error',true),
                    ];
                }
            }
        }
        
        if(count($errors) > 0){
            $this->response->setData($errors)->out();
        }
        
        $required = ['name','surname','birthday']; // birthday
        // CHILDREN CHECK
        if(count($arr['children']) > 0 ){
            
            foreach($arr['children'] as $index=>  $children){
                foreach($required as $require){
                    if(empty($children[$require])){
                        $errors[] = [
                            'key' => 'children'.$index.'_'.$require,
                            'message' => _lang('booking.children.error',true),
                        ];
                    }
                }
            }
        }
        
        if(count($errors) > 0){
            $this->response->setData($errors)->out();
        }
        
        if($arr['aggregment'] != true){
            array_push($errors,['message' => _lang('booking.personal.error', true) , 'key' => 'aggregment']);
            $this->response->setMessage(_lang('booking.personal.error', true))->setData($errors)->out();
        }
        
        return $arr;
    }
    
    
    public function getBooking($data){
        
        $req = new \stdClass();
        $req->adults   = count($data['traveller']);
        
        $children = [];
        if(count($data['children']) > 0 ){
            foreach($data['children'] as $child) {
                if(!empty($child['birthday'])) {
                    array_push($children, ['jahre' => (date('Y') - date('Y',strtotime($child['birthday'])))]);
                }
            }
        }
        if(count($children) > 0 ){
             $req->children = $children;
        }

        $tourView = new TourView();
        $tour = $tourView->get($data['tour_id']);

        $data['travel'] = array(
            'start'         => '',
            'end'           => '',
            'city'          => $tour['destination']
        );

        $opts = [
            'tour_id' => $data['tour_id'],
            'period_id' => $data['period_id'],
            'station_id' => $data['station_id'],
            'children'  => count($data['children']),
            'adult'     => count($data['traveller'])
        ];

        $summary = $tourView->getSummary($opts);
        $price = floatval($summary['station']['price']) * (int)$summary['adult'];
        $price += floatval($summary['station']['child_price'] > 0 ? $summary['station']['child_price'] : $summary['station']['price']) * (int)$summary['children'];

        $data['travel'] = array(
            'start'         => date('d.m.Y',$summary['period']['start_date']),
            'end'           => date('d.m.Y',$summary['period']['end_date']),
            'city'          => $summary['tour']['destination']. ' (Kalkış Durağı : '.$summary['station']['station'].')'
        );

        $data['amount']          = $price;
        $data['currency'] = 'EUR';
        $data['service']         = [];
        $data['available_count'] = $summary['period']['available_count'] - ((int)$summary['adult']+  (int)$summary['children']);
        $data['period']          = $summary['period']['id'];
        $data['service']  = '';
        $data['duration'] = count($tour['plans']);
        $data['operator'] = 'TRIBUS';
        $data['hotel'] = array(
            'giata' => $data['tour_id'],
            'name'  => $tour['title']
        );
        return $data;
        
     //   $this->response->setData($offers)->setStatus(!$offers['error'])->setMessage($offers['message'])->out();
    }

    public function fetch($id = -1)
    {
        $booking = BookingObj::where('tour_id',$id)->groupBy('status')->selectRaw('status,count(*) as cnt')->get();
        $this->response->setStatus(true)->setData($booking)->out();
    }
}
