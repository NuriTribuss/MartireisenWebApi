<?php

namespace Application\Api\Booking\Tour;

use Core\Base\Webservice;
use Model\Tour\Station as Model;
use Model\Tour\Period;

class Station extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
             
            $periodId = \Helper\Input::get('period_id');
             
            $model = $this->build(Model::where(['period_id' => $periodId]));
            $pagination = [
                'total' => $model->count(),
                'page'  => \Helper\Input::get('page',1)
            ];
            if (count($this->sortParams) == 0) {
                $model->orderBy('id', 'desc');
            }
            
            $skip   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $data   = $model->skip($skip)->take($this->limit)->get()->toArray();
            
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
    public function store() {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'period_id' => 'required',
            'station' => 'required'
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $period = Period::find($data->period_id);
        
        $record = new Model;        
        $record->period_id        = $data->period_id;
        $record->tour_id          = $period->tour_id;
        $record->station          = isset($data->station) ? (string)$data->station : '';
        $record->hour             = isset($data->hour) ? (string)$data->hour : '';
        $record->price            = isset($data->price) ? (int)$data->price : '';
        $record->child_price      = isset($data->child_price) ? (int)$data->child_price : '';
        $record->sort_number      = isset($data->sort_number) ? (int)$data->sort_number : 1;
        
        $record->save();
        
        $this->response->setStatus(true)->setData(['inserted' => $record->id])->out();
    }
    
    public function update($id = 0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'period_id' => 'required',
            'station' => 'required'
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
        
        $record->station          = isset($data->station) ? (string)$data->station : $record->station;
        $record->hour             = isset($data->hour) ? (string)$data->hour : $record->hour;
        $record->price            = isset($data->price) ? (int)$data->price : $record->price;
        $record->child_price      = isset($data->child_price) ? (int)$data->child_price : $record->child_price;
        $record->sort_number      = isset($data->sort_number) ? (int)$data->sort_number : $record->sort_number;
        $record->save();
        
        $this->response->setStatus(true)->out();
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $code = Model::find($id);
        if($code != NULL){
            $return = $code->toArray();
            $this->response->setStatus(true)->setData($return)->out();

        }
        
        $this->response->out();

    }
    
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->delete();
        $this->response->setStatus(true)->out();
    }     
}
