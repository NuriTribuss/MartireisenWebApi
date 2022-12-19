<?php

namespace Application\Api\Content\Homepage;

use Core\Base\Webservice;
use Model\Block\Week as Model;

class Week extends Webservice {

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
        $record->code             = $data->code;
        $record->type             = isset($data->type) ? (int)$data->type : 0;
        $record->api_active       = $record->type == 1 ? 1 : 0;
        $record->giata_ids        = isset($data->giata_ids) ? (string)$data->giata_ids : '';
        $record->sort_number      = isset($data->sort_number) ? (int)$data->sort_number : 1;
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
        
        $record->code               = isset($data->code) ? (string)$data->code: $record->code;
        $record->giata_ids          = isset($data->giata_ids) ? (string)$data->giata_ids: $record->giata_ids;
        $record->type               = isset($data->type) ? (int)$data->type : $record->type;
        $record->api_active         = $record->type == 1 ? 1 : 0;
        $record->sort_number        = isset($data->sort_number) ? (int)$data->sort_number : $record->sort_number;
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
