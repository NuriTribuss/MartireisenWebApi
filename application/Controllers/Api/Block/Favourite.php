<?php

namespace Application\Api\Block;

use Core\Base\Webservice;
use Model\Block\Favourite as Model;

class Favourite extends Webservice {

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
            'gid_id' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record                 = new Model;
        $record->gid_id         = $data->gid_id;
        $record->name           = isset($data->name) ?  $data->name : "";
        $record->country_code   = isset($data->country_code) ?  $data->country_code : "";
        $record->country_title  = isset($data->country_title) ? $data->country_title :  "";
        $record->city_code      = isset($data->city_code) ? (string) $data->city_code : '';
        $record->city_title     = isset($data->city_title) ? (string) $data->city_title : '';
        $record->price          = isset($data->price) ? (string) $data->price : '';
        $record->sort_number    = isset($data->sort_number) ? (int) $data->sort_number : 99;
        $record->save();

        $this->response->setStatus(true)->setData(['inserted' => $record->id])->out();
    }
    
    public function update($id = 0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'gid_id' => 'required',
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
        
        $record->gid_id             = isset($data->gid_id) ? (string)$data->gid_id: $record->gid_id;
        $record->name               = isset($data->name) ? (string)$data->name: $record->name;
        $record->country_code       = isset($data->country_code) ? (string)$data->country_code: $record->country_code;
        $record->country_title      = isset($data->country_title) ? (string)$data->country_title: $record->country_title;
        $record->city_code          = isset($data->city_code) ? (string)$data->city_code: $record->city_code;
        $record->city_title         = isset($data->city_title) ? (string)$data->city_title: $record->city_title;
        $record->sort_number        = isset($data->sort_number) ? (string)$data->sort_number: $record->sort_number;
        $record->price              = isset($data->price) ? (string)$data->price: $record->price;
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
