<?php

namespace Application\Api\Marketing;

use Core\Base\Webservice;
use Model\Campaign\Coupon as Model;

class Coupon extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
             
            $model = $this->build(Model::whereRaw('1 = 1'));
            $pagination = [
                'total' => $model->count(),
                'page'  => \Helper\Input::get('page',1)
            ];
            
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
            'code' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = new Model;        
        $record->code           = $data->code;
        $record->discount_type  = isset($data->discount_type) ? (int)$data->discount_type : 1;
        $record->value          = isset($data->value) ? (int)$data->value : 0;
        $record->min_amount     = isset($data->min_amount) ? (int)$data->min_amount : 0;
        $record->start_time     = isset($data->start_time) ? (string)$data->start_time : '';
        $record->end_time       = isset($data->end_time) ? (string)$data->end_time : '';
        
        $record->save();
        
        $this->response->setStatus(true)->setData(['inserted' => $record->id])->out();
    }
    
    public function update($id = 0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'code' => 'required',
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
        
        $record->code           = isset($data->code) ? (string)$data->code: $record->code;
        $record->discount_type  = isset($data->discount_type) ? (int)$data->discount_type: $record->discount_type;
        $record->value          = isset($data->value) ? (int)$data->value: $record->value;
        $record->min_amount     = isset($data->min_amount) ? (int)$data->min_amount: $record->min_amount;
        $record->start_time     = isset($data->start_time) ? (string)$data->start_time: $record->start_time;
        $record->end_time       = isset($data->end_time) ? (string)$data->end_time: $record->end_time;
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
