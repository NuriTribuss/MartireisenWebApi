<?php

namespace Application\Api\Engine;

use Model\Booking\Notes;
use Model\Providers\Connector;
use Model\Booking\Booking as BookingObj;
use Model\Booking\Travellers;
use Core\Base\Service;

class Booking extends Service {
            
    private $connector;
    
    const BOOKING_PENDING = 0;
    const BOOKING_COMPLETED = 1;
    
    function __construct() {
        parent::__construct();
        $this->connector = new Connector();
    }
    
    public function create()
    {

        $data = $this->check();
        $create = $this->getBooking($data);

        $booking = new BookingObj;

        $booking->ref = $data['ref'];
        $booking->name = $data['personal']['name'];
        $booking->surname = $data['personal']['surname'];
        $booking->gender = $data['personal']['gender'];

        $booking->phone = $data['personal']['phone'];
        $booking->email = $data['personal']['email'];
        $booking->birthday = $data['personal']['birthday'];
        $booking->address = $data['personal']['address'];
        $booking->country = $data['personal']['country'];
        $booking->state = $data['personal']['state'];
        $booking->city = $data['personal']['city'];
        $booking->status = self::BOOKING_PENDING;

        $booking->amount = $create['amount'];
        $booking->currency = $create['currency'];
        $booking->start = $create['travel']['start'];
        $booking->end = $create['travel']['end'];
        $booking->duration = (int)$create['duration'];
        $booking->travel_city = $create['travel']['city'];
        $booking->operator = $create['operator'];
        $booking->hotel_giata_code = $create['hotel']['giata'];
        $booking->hotel_name = $create['hotel']['name'];
        $booking->payment_method = $data['payment']['method'];
        $booking->adult_count = count($data['traveller']);
        $booking->children_count = count($data['children']);


        $booking->save();

        $booking->code = 'M' . date('d') . date('m') . $booking->id;
        $booking->api_code = '';
        $booking->source = 'Traffics';
        $booking->api_service = json_encode($create['service']);
        $booking->customer_id = 0;

        $booking->save();

        // Ulasım bilgileri

        // !!!!!!!!!!!!!!! ######### yapılacak...
        //  $this->setTransport($data['ref'],$booking->code);

        foreach ($data['traveller'] as $traveller) {

            $person = new Travellers();
            $person->booking_code = $booking->code;
            $person->name = $traveller['name'];
            $person->surname = $traveller['surname'];
            $person->birthday = $traveller['birthday'];
            $person->gender = $traveller['gender'];
            $person->save();
        }

        foreach ($data['children'] as $traveller) {

            $person = new Travellers();
            $person->booking_code = $booking->code;
            $person->name = $traveller['name'];
            $person->surname = $traveller['surname'];
            $person->birthday = $traveller['birthday'];
            $person->gender = $traveller['gender'];

            $person->is_children = 1;
            $person->save();
        }

        if ($data['comment'] != null){
            $comment = new Notes();
            $comment->booking_id = $booking->id;
            $comment->user_id = 0; //0: customer - set user_id require auth
            $comment->comment = $data['comment'];
            $comment->save();
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
            $return = $saferpay->checkout(floatval($booking->amount*100),$booking->code , $booking->ref);

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
        if(empty($arr['ref'])) {
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
        
        $this->connector->setFilter($req);
        $offers = $this->connector->checkOffer($data['ref'],'');
        if(!empty($offers)){
            $offers['response']->totalPrice->label = number_format( $offers['response']->totalPrice->value,'2',',','');
        }
        
        if(!in_array($offers['response']->statusCode, ['OK','RQ'])){
            $this->response->setStatus(false)->setMessage($offers['response']->tomaMessage)->out();
        }else{
            
            $record = $offers['response'];
            
            file_put_contents(PATH.'/data/log/offer/'.$data['ref'].'.txt', json_encode($record));
            $data['travel'] = array(
                'start'         => $record->commonOffer->travelDate->fromDate,
                'end'           => $record->commonOffer->travelDate->toDate,
                'city'          => $record->commonOffer->hotelOffer->hotel->location->name
            ); 
            
            $data['amount']   = $record->totalPrice->value;
            $data['currency'] = $record->totalPrice->currency;
            $data['service']  = $record->commonOffer;
            $data['duration'] = $record->commonOffer->travelDate->duration;
            $data['operator'] = $record->commonOffer->tourOperator->code;
            $data['hotel'] = array(
                'giata' => $record->commonOffer->hotelOffer->hotel->giata->hotelId,
                'name'  => $record->commonOffer->hotelOffer->hotel->name
            );
            
        }
        
        return $data;
        
     //   $this->response->setData($offers)->setStatus(!$offers['error'])->setMessage($offers['message'])->out();
    }

}
