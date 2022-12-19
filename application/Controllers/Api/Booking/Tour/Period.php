<?php

namespace Application\Api\Booking\Tour;

use Core\Base\Webservice;
use Model\Tour\Tour;
use Model\Tour\Period as Model;
use Model\Booking\Booking;
use Model\Booking\Status;
use Model\Booking\PaymentMethod;
use Model\Booking\Travellers;

class Period extends Webservice {
    
    public $tourId;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
            
            if(!empty($this->tourId)) {
                $model = $this->build(Model::where(['tour_id' => $this->tourId]));
            }else{
                $model = $this->build(Model::whereRaw('1=1'));
            }
            
            $archive = \Helper\Input::get('archive',0);
            if($archive == 0){
                $model->where('start_date', '>=',time());
            }
            
            $pagination = [
                'total' => $model->count(),
                'page'  => \Helper\Input::get('page',1)
            ];
            if (count($this->sortParams) == 0) {
                $model->orderBy('updated_at', 'desc');
            }
            
            
            $skip   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $data   = $model->skip($skip)->take($this->limit)->get();
            
            foreach($data as $key => &$d){
                $tour  = \Model\Tour\TourTranslation::where('tour_id',$d->tour_id)->where('language','tr')->first();
                $d->title = $tour->name;
            }
            
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data->toArray())->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
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
            $return['start_date_beautify'] = date('d.m.Y',$return['start_date']);
            $return['end_date_beautify'] = date('d.m.Y',$return['end_date']);

            $this->response->setStatus(true)->setData($return)->out();
        }               
        
        $this->response->out();

    }
    
    public function store() {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'start_date' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = new Model;    
        $record->tour_id            = $data->tour_id;
        $record->start_date         = strtotime($data->start_date.' 09:00');
        $record->start_hour         = isset($data->start_hour) ? (string)$data->start_hour : '';
        $record->end_date           = isset($data->end_date) ? (string)strtotime($data->end_date.' 09:00') : '';
        $record->max_count          = isset($data->max_count) ? (int)$data->max_count : 1;
        $record->available_count    = $record->max_count;
        $record->transfer           = isset($data->transfer) ? $data->transfer : 1;
        $record->save();
        
        $this->response->setStatus(true)->setData(['inserted' => $record->id])->out();
    }
    
    public function update($id = 0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'start_date' => 'required',
        ]);
            
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        if((int)$data->id > 0 ){
            $id = $data->id;
        }
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->start_date           = isset($data->start_date) ? (string)strtotime($data->start_date.' 09:00'): $record->start_date;
        $record->start_hour           = isset($data->start_hour) ? (string)$data->start_hour :$record->start_hour;
        $record->end_date             = isset($data->end_date) ? (string)strtotime($data->end_date.' 09:00') :$record->end_date;
        
        if(isset($data->max_count) && $record->max_count != $data->max_count){
            if($data->max_count > $record->max_count){
                $sub = (int)$data->max_count - (int)$record->max_count;
                $record->available_count = (int)$record->available_count + $sub;
            }else{
                $sub =   (int)$record->max_count - (int)$data->max_count;
                $record->available_count = $record->available_count - $sub;
            } 
        }
        
        $record->max_count            = isset($data->max_count) ? (int)$data->max_count : $record->max_count;
        $record->transfer             = isset($data->transfer) ? $data->transfer : $record->transfer;

        $record->save();
        
        $this->response->setStatus(true)->out();
    }
    
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->delete();
        $this->response->setStatus(true)->out();
    }    
    
    public function list($periodId = 0) {
        
        $data       = Booking::where('period_id',$periodId)->where('status','<',2)->get();
        $periodData = Model::find($periodId);
        
        $status   = Status::all()->toArray();
        $payments = PaymentMethod::all()->toArray();
        
        foreach($data as $key => &$element){
           
            $element->status = $this->findEl($status, $element->status);
            $element->payment = $this->findEl($payments, $element->payment_method);
            if($element->payment['is_online'] == 1 && $element->status['id'] != 1){
                unset($data[$key]);
                continue;
            }
            $element->travellers = Travellers::where('booking_code',$element->code)->get()->toArray();
        }
        
        $tourView = new \Model\TourView();
        $summary  = $tourView->getSummary(array('tour_id' => $periodData->tour_id , 'period_id' => $periodId));
        $this->response->setStatus(true)->setParent($summary)->setData($data->toArray())->out();

    }
    
    private function findEl($data,$id){
        foreach($data as $d){
            if($id == $d['id']) {
                return $d;
            }
        }
        return false;
    }
    
}
