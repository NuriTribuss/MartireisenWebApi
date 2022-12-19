<?php

namespace Application\Api\Sys\User;

use Core\Base\Webservice;
use Model\Sys\User\User as Model;
use Model\Sys\User\Group;

class User extends Webservice {

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
        
        if($this->session->group_id != 0){
             $this->response->setMessage('Permission Error')->http(402)->out();
        }
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'username' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = new Model;
        if(empty($data->password)){
            $data->password = \Helper\Input::generateRandomString(8);
        }
        
        $group = Group::where('id',$data->group_id)->first();
        if($group == null){
            $this->response->setMessage('Group not found')->out();
        }
        
        $record->password        =  md5($data->password);
        $record->username        =  preg_replace("/[^a-zA-Z0-9]+/", "",  (string)$data->username);
        $record->firstname       = (string)$data->firstname;
        $record->lastname        = (string)$data->lastname;
        
        $record->group           = $group->name;
        $record->group_id        = (int)$data->group_id;
        $record->mobile_phone    = (string)$data->mobile_phone;
        $record->is_active       = (int)$data->is_active;
        
        $exists = Model::where('username',$record->username)->first();
        if($exists != null){
            $this->response->setMessage('Record Exists')->out();
        }
        
        $record->save();
        
        $this->response->setStatus(true)->out();
    }
    
    public function update($id = 0) {
        
        if($this->session->group_id != 0){
             $this->response->setMessage('Permission Error')->http(402)->out();
        }
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'username' => 'required',
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
        
        $record->username        = isset($data->username) ? $data->username : $record->username;
        $record->firstname       = isset($data->firstname) ? (string)$data->firstname : $record->firstname;
        $record->lastname        = isset($data->lastname) ? (string)$data->lastname : $record->lastname;
        $record->group_id        = isset($data->group_id) ? (int)$data->group_id : $record->group_id;
        $record->mobile_phone    = isset($data->mobile_phone) ? (int)$data->mobile_phone : $record->mobile_phone;
        $record->is_active       = isset($data->is_active) ? (int)$data->is_active :  $record->is_active;
        
        $record->save();
        
        $this->response->setStatus(true)->out();
    }
    
    public function changePassword($userId) {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'password' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($userId);
        if($record == NULL){
           $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->password = md5($data->password);
        $record->save();
        $this->response->setStatus(true)->out();
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $data  = Model::find($id);
        
        if($data != NULL){
            
            $return = $data->toArray();
            $this->response->setStatus(true)->setData($return)->out();
        }
        
        $this->response->out();
    }
    
    public function destroy($id = 0) {
        
        if($this->session->group_id != 0){
             $this->response->setMessage('Permission Error')->http(402)->out();
        }
        
        $record = Model::find($id);
        
        if($record == NULL){
            $this->response->setMessage('Record Not Found')->out();
       }
       
        if($record->id == $this->session->id){
            $this->response->out();
        }
        
        $record->delete();
        $this->response->setStatus(true)->out();
    }     
}
