<?php

namespace Application\Service;

use Core\Base\Service;
use Model\Booking\Booking as BookingObj;
use Model\Booking\Travellers;
use Model\Api\Client\HalalBooking;
use Model\User\Customer as CustomerSession;
use Model\Providers\Connector;

class Booking extends Service{
    
    private $api;
    private $halalBookingApi;
    
    const BOOKING_PENDING = 0;
    const BOOKING_COMPLETED = 1;
    
    public function __construct() {
        
        parent::__construct();
        $this->dbCache->setTimeout(60);
        
        $this->api              = new Connector();
        $this->halalBookingApi  = new HalalBooking();

    }
    
    public function create() {
        
        $data      = $this->check();
        $create    = $this->checkApiBooking($data);          
       
        $booking   = new BookingObj;
        
        $booking->ref           = $data['ref'];
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
        $booking->language      = CustomerSession::getLanguage();
        $booking->status        = self::BOOKING_PENDING;
        
        $booking->amount             = $create['amount'];
        $booking->currency           = $create['currency'];
        $booking->start              = $create['travel']['start'];
        $booking->end                = $create['travel']['end'];
        $booking->duration           = (int) $create['duration'];
        $booking->travel_city        = $create['travel']['city'];
        $booking->operator           = $data['operator'];
        $booking->hotel_giata_code   = $data['hotel']['giata'];
        $booking->hotel_name         = $data['hotel']['name'];
        $booking->payment_method     = $data['payment']['method'];
        $booking->adult_count        = count($data['traveller']);
        $booking->children_count     = count($data['children']);
       
        $booking->save();
        
        $booking->code        = 'M'.date('d').date('m').$booking->id;
        $booking->api_code    = $data['halalbooking'] == 1 ? '' : (string)$data['booking']['VGNR'];
        $booking->source      = $this->getType($data);  
        $booking->api_service = json_encode($create['service']);
        $booking->customer_id = (int)CustomerSession::getId();
        
        if($data['tour'] == 1){
            
            $period = \Model\Tour\Period::find($create['period']);
            $booking->tour_id   = $booking->hotel_giata_code;
            $booking->period_id = $period->id;
        }
        
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
        
        \Core\Session\Session::set('last_booking', $booking->code);
        \Core\Session\Session::set('booking_data',$data);

        if($data['payment']['method'] == 2){
            
            $sofort = new \Helper\Payment\Sofort();
            $return = $sofort->checkout(floatval($booking->amount),$booking->code);
            
            if($return['status'] == false) {
                $booking->transaction_error = $return['data'];
                $booking->save();
            }else{
                $booking->transaction_id    = $return['data'];
                $booking->save();
                \Core\Session\Session::set('payment_transaction', $return['data']);
                $this->response->setData($return)->setStatus(true)->out();
            }
            
        }else if($data['payment']['method'] == 3){
            
            $saferpay = new \Helper\Payment\Saferpay();
            $return = $saferpay->checkout(floatval($booking->amount*100),$booking->code);

            if($return['status'] == false) {
                $booking->transaction_error = $return['data'];
                $booking->save();
            }else{
                $booking->transaction_id    = $return['data'];
                $booking->save();
                \Core\Session\Session::set('payment_transaction', $return['data']);
                $this->response->setData($return)->setStatus(true)->out();
            }
        }else{
            
            if($data['halalbooking'] == 1){
                
                $create     = $this->halalBookingApi->createBooking($data);
                $create     = json_decode(json_encode($create),true);
                
                if($create['id'] == 'booking_invalid'){
                    $this->response->setMessage($create['message'])->out();
                }
                if($create  == NULL){
                    $this->response->setMessage(_lang('booking.unknown_error',true))->out();
                }
                
                $booking->api_code = $create['code'];
                $booking->save();
                
            }else if ($data['tour'] == 1 ){
                
                if($period != NULL){
                    
                    $period->available_count = $create['available_count'];
                    $period->save();
                    
                    $tourView = new \Model\TourView();
                    $tourView->deleteCacheById($period->tour_id);
                }
                
            }else{
                $create     = $this->api->createBooking($data);
                if(isset($create['error'])){
                    $this->response->setMessage(_lang('booking.unknown_error',true))->out();
                }
                if($create['response']->statusCode != 'OK' && $create['response']->statusCode !='NK'){
                    $this->response->setMessage($create['response']->api_error)->out();
                }
                
                $booking->api_code = $create['response']->trafficsBookingCode;
                $booking->save();
            }
            
            try{
                $mail = new \Model\Mail\Customer();
                $mail->sendBookingRequested($data['personal']['email'], $booking->toArray());
            }catch(\Exception $e){
                
            }
            
        }
        
        $this->response->setData($create)->setStatus(true)->out();
    }
    
    public function checkApiBooking($data) {
        
        if($data['halalbooking'] == 1){
            
            $data       = $this->checkHalalAvailable($data);
            $create['service']  = $data['booking'];
           
        }else if($data['tour'] == 1){
            $data       = $this->checkTourAvailable($data);
            $create['service']  = $data['booking'];
            $create['available_count']  = $data['available_count'];
            $create['period']           = $data['period'];

        }else{
            $data   = $this->checkAvailable($data);
            $create['service'] = $data['service'];
        }   
        
        $create['travel']   = $data['travel'];
        $create['amount']   = $data['amount'];
        $create['currency'] = $data['currency'];
        $create['duration'] = (int)$data['duration'];
        
        return $create;
    }
    
    public function check() {
        
        
        $arr = json_decode(file_get_contents('php://input'), true);
        
        if($arr['tour']!= 1){
            $arr['ref'] = \Core\Session\Session::get('bookingRef');
        }
        
        if($arr == NULL) {
            $this->response->setMessage('Invalid Request')->out();
        }
                
        if(empty($arr['ref'])) {
            $this->response->setMessage('Invalid Request')->out();
        }
        
        
        $personalRequired = ['name','surname','phone','email','address','country','state','city','gender'];
        if($arr['tour']!= 1){
            array_push($personalRequired,'birthday');
        }
        
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
        
        if($arr['aggregment'] != true && $arr['tour']!= 1){
            array_push($errors,['message' => _lang('booking.personal.error', true) , 'key' => 'aggregment']);
            $this->response->setMessage(_lang('booking.personal.error', true))->setData($errors)->out();
        }
        
        return $arr;
    }
    
    // TRAVEL IT API
    
    public function checkAvailable($data) {
      
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
        
            
        $this->api->setFilter($req);
        
        $response = $this->api->checkOffer($data['ref']);
       
        if($response['response']->statusCode != 'OK'){
            $this->response->setStatus(false)->setMessage(_lang('offer.not_available',true))->out();
        }else{
            
            $record = $response['response'];
            
            file_put_contents(PATH.'/data/log/offer/'.$data['ref'].'.txt', json_encode($record));
            $data['travel'] = array(
                'start'         => $record->commonOffer->travelDate->fromDate,
                'end'           => $record->commonOffer->travelDate->toDate,
                'city'          => $record->commonOffer->hotelOffer->hotel->location->name
            ); 
            
            $data['amount']   = $record->totalPrice->value;
            $data['currency'] = $record->totalPrice->currency;
            $data['service']  = '';
            $data['duration'] = $record->commonOffer->travelDate->duration;
        }
       
        return $data;
    }
    
    public function checkHalalAvailable($data) {
        
        $this->halalBookingApi->setParams($data);
        $resp  = $this->halalBookingApi->hotel($data['hotel']['giata']);
        
        $offer = false;
        
        for($i=0; $i < count($resp->groups); $i++){
            for($j= 0; $j < count($resp->groups[$i]->offers); $j++){
                $el = (array)$resp->groups[$i]->offers[$j];
                if($el['rate_plan']->id == $data['rate_plan_id'] && $el['room']->id == $data['room_id']){
                    $offer = $el;
                }
            }
        }
        
        if($offer == false){
            $this->response->setStatus(false)->setMessage(_lang('offer.not_available',true))->out();
        }else{
            
            $data['travel'] = array(
                'start'         => $data['date']['start'],
                'end'           => $data['date']['end'],
                'city'          => 'Halal'
            ); 

            $data['amount']     = $offer['price'];
            $data['currency']   = \Model\User\Customer::getCurrency();
        }
       
        
        return $data;
    }
    
    public function checkTourAvailable($data) {
        
        $tourView = new \Model\TourView();
        
        $bookingObj = \Core\Session\Session::get('booking_tour'); 
        if($bookingObj == null) {
            $this->response->setMessage('Invalid Request, Tour Data')->out();
        }
        
        $summary = $tourView->getSummary($bookingObj);
        $price = floatval($summary['station']['price']) * (int)$summary['adult'];
        $price += floatval($summary['station']['child_price'] > 0 ? $summary['station']['child_price'] : $summary['station']['price']) * (int)$summary['children'];
       
        if($summary['period']['available_count'] <   (int)$summary['adult'] +  (int)$summary['children']){
            $this->response->setStatus(false)->setMessage(_lang('offer.not_available',true))->out();
        }else{
            
            $data['travel'] = array(
                'start'         => date('d.m.Y',$summary['period']['start_date']),
                'end'           => date('d.m.Y',$summary['period']['end_date']),
                'city'          => $summary['tour']['destination']. ' (Kalkış Durağı : '.$summary['station']['station'].')'
            ); 

            $data['amount']          = $price;
            $data['currency']        = \Model\User\Customer::getCurrency();
            $data['service']         = [];
            $data['available_count'] = $summary['period']['available_count'] - ((int)$summary['adult']+  (int)$summary['children']);
            $data['period']          = $summary['period']['id'];

        }
        return $data;
    }
    
    public function setTransport($ref,$code = '') {
        
        $flight = $this->api->getFlightInfo($ref);
        if($flight['FEHLERTEXT'] == 'OK'){
            
            foreach($flight['FLIGHT_OUT']['FLIGHT'] as $data){
                $data['direction'] = 'out';
                $this->addTransport($data, $code);
            }
            
            foreach($flight['FLIGHT_IN']['FLIGHT'] as $data){
                $data['direction'] = 'in';
                $this->addTransport($data, $code);
            }            
        }
        return true;
    }
    
    public function addTransport($data,$code) {
        
        if(empty($data['FL_NUM'])){
            return false;
        }
        
        $flight = new \Model\Booking\Transports();
        $flight->booking_code       = $code;
        $flight->direction          = $data['direction'];
        $flight->airline            = $data['FL_AIRLINE'];
        $flight->flight_number      = $data['FL_NUM'];
        $flight->flight_overnight   = $data['FL_OVERNIGHT'];
        $flight->arr_country        = $data['ARR_COUN'];
        $flight->arr_name           = $data['ARR_NAME'];
        $flight->arr_iata           = $data['ARR_IATA'];
        $flight->arr_date           = $data['ARR_DATE'];
        $flight->arr_time           = $data['ARR_TIME'];
        $flight->dep_country        = $data['DEP_COUN'];
        $flight->dep_name           = $data['DEP_NAME'];
        $flight->dep_iata           = $data['DEP_IATA'];
        $flight->dep_date           = $data['DEP_DATE'];
        $flight->dep_time           = $data['DEP_TIME'];
        $flight->save();
        
        return $flight->id;
    }
    
    // HALALBOOKING API
    
    // KUPON
    
    public function setDiscount($coupon,$total) {
       
        if(empty($coupon)){
             $this->response->setStatus(false)->setMessage(_lang('offer.coupon_code_empty',true))->out();
        }
        
        $total = str_replace(',','.',str_replace('.','',$total));
        $discount = $this->calculateDiscount($total,$coupon);
        if($discount == false){
            $this->response->setStatus(false)->setMessage(_lang('offer.coupon_code_invalid',true))->out();
        }
        
        $return = array(
            'price_base'=> number_format($total,2,',','.') ,
            'price'     => number_format($total - $discount,2,',','.') ,
            'discount'  => $discount
        );
        
        \Core\Session\Session::set('discount_coupon',$coupon);
        $this->response->setStatus(true)->setData($return)->setMessage(_lang('offer.coupon_code_success',true))->out();
    }
    
    public function calculateDiscount($total,$coupon = '') {
       
        if(empty($coupon) || empty($total)){
            return 0;
        }

        $return = array(
            'discount' => 0 ,
            'code'     => $coupon
        );
        
        $couponModel  = new \Model\Campaign\Coupon();
        $discount     = $couponModel->calculate($coupon,(float)$total);
       
        if($discount!== false){
            $return['discount'] = $discount;
        }
        
        return $discount;
    }
    
    
    public function process() {
        
        $transaction = \Core\Session\Session::get('payment_transaction');
        $record      = BookingObj::where('transaction_id',$transaction)->first();
        
        if($record != NULL && $record->payment_method > 1){
            
            if($record->payment_method == 2) {
                $sofort = new \Helper\Payment\Sofort();
                $status = $sofort->checkTransaction($transaction);
                $status = in_array($status,$sofort->successStatus);
                
            }else if($record->payment_method == 3){
                
                $saferPay = new \Helper\Payment\Saferpay();
                $status  = $saferPay->checkTransaction($transaction);
                $status  = $status['data'] == 'AUTHORIZED' ? true : false;
            }
           
            if($status == true){
                
                $data   = $record->toArray();
                $travellers = Travellers::where('booking_code',$data['code'])->get();
                $data['travellers'] = $travellers->toArray();

                $apiData = array(
                    'ref'      => $data['ref'],
                    'personal' => array(
                        'name'      => $data['name'],
                        'surname'   => $data['surname'],
                        'birthday'  => $data['birthday'],
                        'address'   => $data['address'],
                        'state'     => $data['state'],
                        'city'      => $data['city'],
                        'country'   => $data['country'],
                        'phone'     => $data['phone'],
                        'email'     => $data['email']
                    ),
                    'children' => [],
                    'traveller'=> [],
                    'booking'  => array(
                        'VGNR'          => $data['api_code'],
                        'ACCOMMODATION' => array('GID' => $data['hotel_giata_code']),
                        'GPREIS'        => (int)$data['amount'],
                    )
                );

                foreach($data['travellers'] as $traveller){
                    $arr = array(
                        'name'      => $traveller['name'],
                        'surname'   => $traveller['surname'],
                        'birthday'  => $traveller['birthday'],
                        'gender'    => (int)$traveller['gender']
                    );

                    if($traveller['is_children'] == 0 ){
                        array_push($apiData['traveller'],$arr);
                    }else{
                        array_push($apiData['children'],$arr);
                    }
                }
                if($record->source != 'Tour') {
                    $create     = $this->api->createBooking($apiData);
                    if(isset($create['error'])){
                        $this->response->setMessage(_lang('booking.unknown_error',true))->out();
                    }
                   
                    if(!($create['response']->statusCode == 'OK' || $create['response']->statusCode =='NK')){
                        $this->response->setMessage('An Error Occured')->out();
                    }
                 
                }else{
                    $create['service'] = [];
                    $period = \Model\Tour\Period::find($record->period_id);
                    if($period != NULL){
                        $period->available_count = $period->available_count - count($data['travellers']);
                        $period->save();
                    }
                }
                
                $record->api_service = json_encode([]);
                $record->payment_received = 1;
                $record->status  =1;
                $record->save();
                
                \Core\Session\Session::clear('payment_transaction');
                
                try{
                    $mail = new \Model\Mail\Customer();
                    $mail->sendBookingRequested($apiData['personal']['email'], $record->toArray());
                }catch(\Exception $e){
                    
                }
               
                 \Core\Http\Redirect::go('/booking/complete');
            }else{
                $record->status  =3;
                $record->save();
                 \Core\Http\Redirect::go('/booking/failure');
            }
        }else{
           die('Unavilable Request');
        }
    }
    
    public function getType($data) {
        
        if($data['halalbooking'] == 1){
            return 'HalalBooking';
        }
        
        if($data['tour'] == 1 ){
            return 'Tour';
        }
        
        return 'Traffics';
    }
    
    public function init() {
        
        $data = \Core\Session\Session::get('booking_data');
        if(!empty($data) && is_array($data)){
            \Core\Session\Session::clear('booking_data');
            $this->response->setData($data)->setStatus(true)->out();
        }else{
            $this->response->out();

        }
    }

}