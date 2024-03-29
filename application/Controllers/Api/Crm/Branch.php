<?php

namespace Application\Api\Crm;

use Core\Base\Webservice;
use Model\Content\Branch as Model;

class Branch extends Webservice {

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
            'name' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = new Model;        
        $record->name           = $data->name;
        $record->sort_number    = isset($data->sort_number) ? (int)$data->sort_number : 999;
        $record->address        = isset($data->address) ? (string)$data->address : '';
        $record->email          = isset($data->email) ? (string)$data->email : '';
        $record->phone          = isset($data->phone) ? (string)$data->phone : '';
        $record->fax            = isset($data->fax) ? (string)$data->fax : '';
        $record->week_hours     = isset($data->week_hours) ? (string)$data->week_hours : '';
        $record->weekend_hours  = isset($data->weekend_hours) ? (string)$data->weekend_hours : '';
        $record->map_x          = isset($data->map_x) ? (string)$data->map_x : '';
        $record->map_y          = isset($data->map_y) ? (string)$data->map_y : '';
        $record->save();
        
        $this->response->setStatus(true)->setData(['inserted' => $record->id])->out();
    }
    
    public function update($id = 0) {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name' => 'required',
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
        $record->name          = isset($data->name) ? (string)$data->name : $record->name;
        $record->address        = isset($data->address) ? (string)$data->address : $record->address;
        $record->email          = isset($data->email) ? (string)$data->email : $record->email;
        $record->phone          = isset($data->phone) ? (string)$data->phone : $record->phone;
        $record->fax            = isset($data->fax) ? (string)$data->fax : $record->fax;
        $record->week_hours     = isset($data->week_hours) ? (string)$data->week_hours : $record->week_hours;
        $record->weekend_hours  = isset($data->weekend_hours) ? (string)$data->weekend_hours : $record->weekend_hours;
        $record->map_x          = isset($data->map_x) ? (string)$data->map_x : $record->map_x;
        $record->map_y          = isset($data->map_y) ? (string)$data->map_y : $record->map_y;
        $record->active         = isset($data->active) ? (int)$data->active : $record->active;        
        $record->sort_number    = isset($data->sort_number) ? (int)$data->sort_number : $record->sort_number;        
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
