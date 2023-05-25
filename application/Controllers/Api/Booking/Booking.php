<?php

namespace Application\Api\Booking;

use Core\Base\Webservice;
use DateTime;
use Helper\Input;
use Model\Booking\Booking as Model;
use Model\Booking\Notes;
use Model\Booking\Travellers;
use Model\Booking\PaymentMethod;
use Model\Booking\Status;
use Model\Booking\Transports;
use Model\Log\Admin as Logger;

class Booking extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
             
            $model = Model::whereRaw('1 = 1');
            $filter = $_GET;
            $model = $this->filter($model,$filter);
            $pagination = [
                'total' => $model->count(),
                'page'  => \Helper\Input::get('page',1)
            ];
            
            $status   = Status::all()->toArray();
            $payments = PaymentMethod::all()->toArray();
            
            if (count($this->sortParams) == 0) {
                $model->orderBy('id', 'desc');
            }
            
            $skip   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $data   = $model->skip($skip)->take($this->limit)->get()->toArray();
            
            foreach($data as $key => $d){
                $data[$key]['status'] = $this->findEl($status, $d['status']);
                $data[$key]['payment'] = $this->findEl($payments, $d['payment_method']);

            }
            
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }    
    
    // sadece tur için
    
    public function addTraveller() {
       
        $data = \Helper\Input::json();
        
        if(empty($data->booking_code)){
            $this->response->setMessage('Booking Code Not Empty')->out();
        }
        if(empty($data->name)){
            $this->response->setMessage('Name Not Empty')->out();
        }
        $booking = Model::where(['code' => $data->booking_code])->first();
        if($booking == null){
            $this->response->setMessage('Booking Code Not Found')->out();
        }
        
        if($booking->source != 'Tour'){
            $this->response->setMessage('Only Tour booking editable')->out();
        }
        
        if($booking->payment_method != 1){
            $this->response->setMessage('Only Bank transfer booking editable')->out();
        }
        
        $traveller                  = new Travellers();
        $traveller->booking_code    = $data->booking_code;
        $traveller->name            = $data->name;
        $traveller->gender          = $data->gender;
        $traveller->surname         = $data->surname;
        $traveller->is_children     = $data->is_children;
        $traveller->is_custom       = 1;
        $traveller->save();
        
        
        $opts = [
            'period_id'  => $booking->period_id,
            'tour_id'    => $booking->tour_id,
           // 'station_id' => $booking->station_id 
        ];
        
        $tourView = new \Model\TourView();
        $t =  $tourView->getSummary($opts);
        
        if($t == false){
            $this->response->setMessage('Tour Not Found')->out();
        }
        
        $period = \Model\Tour\Period::where('id',$booking->period_id)->first();
        if($period == null || $period->available_count == 0 ){
            $this->response->setMessage('Period Not Available')->out();
        }
        
        $period->available_count-=1;
        $period->save();
                
        if($data->is_children == 1){
            $booking->children_count+=1;
            $booking->amount+= (int)$t['station']['child_price'];
        }else{
            $booking->adult_count+=1;
            $booking->amount+= (int)$t['station']['price'];

        }
        
        $booking->save();
        
        $log = [
            'module'  => 'BOOKING',
            'module_code' => $booking->id,
            'message' => 'Booking added traveller'.$traveller->name
        ];
                
        $logger = new Logger;
        $logger->log($log);
        
        $this->response->setStatus(true)->out();

    }
    
    public function deleteTraveller() {
        
        $data = \Helper\Input::json();
        
        if(empty($data->booking_code)){
            $this->response->setMessage('Booking Code Not Empty')->out();
        }
        
        $booking = Model::where(['code' => $data->booking_code])->first();
        if($booking == null){
            $this->response->setMessage('Booking Code Not Found')->out();
        }
        
        $traveller = Travellers::where('id',$data->id)->first();
        if($traveller == null){
            $this->response->setMessage('Traveller Not Found')->out();
        }
        
        $opts = [
            'period_id'  => $booking->period_id,
            'tour_id'    => $booking->tour_id,
           // 'station_id' => $booking->station_id 
        ];
        
        $tourView = new \Model\TourView();
        $t =  $tourView->getSummary($opts);
        
        if($t == false){
            $this->response->setMessage('Tour Not Found')->out();
        }
        
        $period = \Model\Tour\Period::where('id',$booking->period_id)->first();
        if($period == null ){
            $this->response->setMessage('Period Not Available')->out();
        }
        
        $period->available_count+=1;
        
        if($traveller->is_children == 1){
            $booking->children_count-=1;
            $booking->amount-= (int)$t['station']['child_price'];
        }else{
            $booking->adult_count-=1;
            $booking->amount-= (int)$t['station']['price'];
        }
        
        $traveller->delete();
        $booking->save();
        $period->save();
        
        $log = [
            'module'  => 'BOOKING',
            'module_code' => $booking->id,
            'message' => 'Booking delete traveller'.$traveller->name
        ];
                
        $logger = new Logger;
        $logger->log($log);
        
        $this->response->setStatus(true)->out();

    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $record = Model::find($id);
        
        if($record != NULL){
            
            $return                 = $record->toArray();
            $travellers             = Travellers::where('booking_code',$return['code'])->get();
            $return['travellers']   = $travellers->toArray();
            $return['service']      = json_decode($return['api_service'],true);
            $return['payment']      = PaymentMethod::where('id',$record->payment_method)->first()->toArray();
            $return['status']       = Status::where('id',$record->status)->first()->toArray();
            $flights = Transports::where('booking_code',$return['code'])->get(); 
            $return['flights'] = $flights->toArray();
            $return['notes'] = Notes::where('booking_id',$id)->with('user')->get();
            $return['api']          = [];
            $file = PATH.'/data/log/offer/'.$record->ref.'.txt';
            if(file_exists($file)){
                $return['offer'] = json_decode(file_get_contents($file),true);
            }else{
                $return['offer'] = null;
            }
            if($record->source == 'Traffics'){
               // $connector = new \Model\Providers\Connector();
               // $data = $connector->booking($record->api_code);
               // $return['api'] = $data['response']->bookingList[0];
            }
          
            $this->response->setStatus(true)->setData($return)->out();
        }               
        
        $this->response->out();

    }
    
    public function approve($id) {
        
        $record = Model::find($id);
        if($record == NULL){
            $this->response->setMessage('Record Not Found')->out();
        }
        if(empty($record->api_code)) {
            $this->response->setMessage('Api Code Not Found')->out();
        }
        
        if($record->source != 'Traffics') {
            $this->response->setMessage('Only Traffics bookings available')->out();
        }
        
        $client = new \Model\Providers\Traffics\Client();
        $return = $client->updateBooking($record->api_code, ['type' => 'through']);
        if($return["api_error"] != null)
        {
            $this->response->setStatus(false)->setMessage($return["api_error"])->out();
            return;
        }
        $record->mode = 'through';
        $record->save();
        
        $this->response->setStatus(true)->out();

    }
    
    public function update($id = 0) {
        
        $data = \Helper\Input::json();        
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if($record->status == 2 ){
            $this->response->setMessage('This booking can not be update')->out();
        }
        
        
        $updateStock = true;
        if($record->status == 0 && in_array((int)$record->payment_method, [2,3]) ){
            $updateStock = false;
        }
        
        $record->status          = isset($data->status) ? (int)$data->status : $record->status;
        if(isset($data->status) && $updateStock){
            $this->changeStatus($record);
        }
        $record->save();
        
        $this->response->setStatus(true)->out();
    }
    
    private function changeStatus($record){
        
        if($record->status == 2){
            $cancel = new \Model\Booking\Cancel();
            $cancel->change($record);
        }
        
        $opts = [
            'module'  => 'BOOKING',
            'module_code' => $record->id,
            'message' => 'Booking info changed (status, '.$record->status.')' 
        ];
                
        $logger = new Logger;
        $logger->log($opts);
    }
    
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->delete();
        $this->response->setStatus(true)->out();
    }    
    
    private function filter($entity,$filter) {

        $params = $filter;
        if (!empty($params['code'])) {
            $entity = $entity->where('code', 'LIKE', '%' . $params['code'] . '%');
        }
        if (!empty($params['source'])) {
            $entity = $entity->where('source',$params['source']);
        }
        
        if (!empty($params['email'])) {
            $entity = $entity->where('email', 'LIKE', '%' . $params['email'] . '%');
        }
        
        if (!empty($params['name'])) {
            $entity = $entity->where('name', 'LIKE', '%' . $params['name'] . '%');
        }

        if (!empty($params['surname'])) {
            $entity = $entity->where('surname', 'LIKE', '%' . $params['surname'] . '%');
        }
        
        // 2020-01-25 00:00:00
        if (!empty($params['created_at'])) {
            if (!empty($params['created_at']['min'])) {
                $created_at_min = new DateTime($params['created_at']['min']);
                $created_at_min_str = $created_at_min->format('Y-m-d');
                $entity = $entity->where('created_at', '>=', $created_at_min_str);
            }
            if (!empty($params['created_at']['max'])) {
                $created_at_max = new DateTime($params['created_at']['max']);
                $created_at_max->modify('+1 day');
                $created_at_max_str = $created_at_max->format('Y-m-d');
                $entity = $entity->where('created_at', '<', $created_at_max_str);
            }
        }
        return $entity;
    }  
    
    private function findEl($data,$id){
        foreach($data as $d){
            if($id == $d['id']) {
                return $d;
            }
        }
        return false;
    }
    
    public function log($bookingId = 0) {
        
        $data = Logger::where(['module' => 'BOOKING' , 'module_code' => $bookingId])->get()->toArray();
        $this->response->setStatus(true)->setData($data)->out();

    }

    public function addnote($id = 0) {
        if(empty((int)$id)){
            $this->response->out();
        }
        $record = Model::find($id); //get booking record where id

        if($record == NULL){  //check exist booking
            $this->response->out();
        }

        $user_id = $this->session->id; // current user id
        //$old_note = Notes::where('booking_id',$id)->where('user_id',$user_id)->first();  // check exist note for this booking record as current user

        if(!$user_id){
            $this->response->out();
        }

        $comment = \Helper\Input::json()->comment;

        $note = new Notes();
        $note->booking_id = $id;
        $note->user_id  = $user_id;
        $note->comment = $comment;
        $note->save();
        //$res = Notes::where('booking_id',$id)->get();
        $this->response->setStatus(true)->out();

    }
    public function updatenote($id = 0) {
        if(empty((int)$id)){
            $this->response->out();
        }

        $user_id = $this->session->id; // current user id
        $note = Notes::where('user_id',$user_id)->find($id);  // check exist note for this booking record as current user

        if(!$user_id || !$note){
            $this->response->out();
        }

        $comment = \Helper\Input::json()->comment;
        $note->comment = $comment;
        $note->save();
        //$res = Notes::where('booking_id',$id)->get();
        $this->response->setStatus(true)->out();
    }

    public function destroynote($id = 0) {
        if(empty((int)$id)){
            $this->response->out();
        }

        $user_id = $this->session->id; // current user id
        $note = Notes::where('user_id',$user_id)->find($id);  // check exist note for this booking record as current user

        if(!$user_id || !$note){
            $this->response->out();
        }
        $note->delete();
        //$res = Notes::where('booking_id',$id)->get();
        $this->response->setStatus(true)->out();
    }
    
}
