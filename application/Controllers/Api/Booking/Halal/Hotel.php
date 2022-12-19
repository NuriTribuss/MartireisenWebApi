<?php

namespace Application\Api\Booking\Halal;

use Core\Base\Webservice;
use Model\Region\HalalHotel as Model;

class Hotel extends Webservice {

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
            
            if (count($this->sortParams) == 0) {
              //  $model->orderBy('start_date', 'desc');
            }
            
            $skip   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $data   = $model->skip($skip)->take($this->limit)->get();
            
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
            
            $return   = $record->toArray();
            $this->response->setStatus(true)->setData($return)->out();
        }               
        
        $this->response->out();

    }
    
    public function update($id = 0) {
        
        $data = \Helper\Input::json();        
        
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
        
        $record->status          = isset($data->status) ? (int)$data->status : $record->status;
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
    
    private function filter($entity) {

        $params = $_GET;

        if (!empty($params['code'])) {
            $entity = $entity->where('code', 'LIKE', $params['code'] . '%');
        }

        if (!empty($params['email'])) {
            $entity = $entity->where('email', 'LIKE', $params['email'] . '%');
        }
        
        if (!empty($params['name'])) {
            $entity = $entity->where('name', 'LIKE', $params['name'] . '%');
        }

        if (!empty($params['surname'])) {
            $entity = $entity->where('surname', 'LIKE', $params['surname'] . '%');
        }
        
        // 2020-01-25 00:00:00

        if (!empty($params['created_at'])) {
            if (isset($params['created_at']['min'])) {
                $entity = $entity->where('created_at', '>=', $params['created_at']['min']);
            }
            if (isset($params['created_at']['max'])) {
                $entity = $entity->where('created_at', '<=', $params['created_at']['max']);
            }
        }

        return $entity;
    }  
}
