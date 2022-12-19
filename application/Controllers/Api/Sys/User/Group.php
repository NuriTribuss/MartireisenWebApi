<?php

namespace Application\Api\Sys\User;

use Core\Base\Webservice;
use Model\Sys\User\Group as Model;
use Model\Sys\User\Permission;

class Group extends Webservice {

    public function __construct() {
        
        parent::__construct();
    }

    public function get() {

        try {

            $model = $this->build(Model::whereRaw('1 = 1'));
            $pagination = [
                'total' => $model->count(),
                'page' => \Helper\Input::get('page', 1)
            ];

            $skip = $pagination['page'] == 1 ? 0 : (($pagination['page'] - 1) * $this->limit);
            $data = $model->skip($skip)->take($this->limit)->get()->toArray();

            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data)->out();
        } catch (\Exception $e) {
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }

    public function store() {

        if ($this->session->group_id != 0) {
            $this->response->setMessage('Permission Error')->http(402)->out();
        }

        $data = \Helper\Input::json();

        $this->validation->validate([
            'name' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = new Model;
        $record->name       = (string) $data->name;
        $record->is_active  = (int) $data->is_active;
        $record->save();

        $this->response->setStatus(true)->out();
    }

    public function update($id = 0) {

        if ($this->session->group_id != 0) {
            $this->response->setMessage('Permission Error')->http(402)->out();
        }

        $data = \Helper\Input::json();

        $this->validation->validate([
            'name' => 'required',
        ]);

        if ($this->validation->hasError()) {
            $this->response->setErrors($this->validation->getErrors())->out();
        }

        if ((int) $data->id > 0) {
            $id = $data->id;
        }

        $record = Model::find($id);
        if ($record == NULL) {
            $this->response->setMessage('Record Not Found')->out();
        }

        $record->name = isset($data->name) ? $data->name : $record->name;
        $record->is_active = isset($data->is_active) ? (int) $data->is_active : $record->is_active;
        $record->save();

        $this->response->setStatus(true)->out();
    }

    public function show($id = 0) {
        if (empty((int) $id)) {
            $this->response->out();
        }

        $return = NULL;
        $data = Model::find($id);

        if ($data != NULL) {

            $return = $data->toArray();
            $this->response->setStatus(true)->setData($return)->out();
        }

        $this->response->out();
    }

    public function destroy($id = 0) {
        if ($this->session->group_id != 0) {
            $this->response->setMessage('Permission Error')->http(402)->out();
        }

        $record = Model::find($id);
       
        if ($record == NULL) {
            $this->response->setMessage('Record Not Found')->out();
        }
 
        if($record->id == 0){
            $this->response->setMessage('This group can not be delete')->out();
        }

        $record->delete();
        $this->response->setStatus(true)->out();
    }

    public function permissions($groupId) {

        $data = file_get_contents(PATH . '/resources/permission/methods.json');
        $data = json_decode($data);

        $return = [];
        $arr    = null;

        foreach ($data as $d) {
            
            $upd = [
                'name' => $d->tag,
                'path' => $d->path,
                'get' => [
                    'available' => in_array('get', $d->methods),
                    'active'    => Permission::where(['method' => 'get', 'route' => $d->path, 'group_id' => $groupId])->first() != null
                ],
                'post' => [
                    'available' => in_array('post', $d->methods),
                    'active'    => Permission::where(['method' => 'post', 'route' => $d->path, 'group_id' => $groupId])->first() != null
                ],
                'put' => [
                    'available' => in_array('put', $d->methods),
                    'active'    => Permission::where(['method' => 'put', 'route' => $d->path, 'group_id' => $groupId])->first() != null
                ],
                'delete' => [
                    'available' => in_array('delete', $d->methods),
                    'active'    => Permission::where(['method' => 'delete', 'route' => $d->path, 'group_id' => $groupId])->first() != null
                ]
            ];
            
            $return[] = $upd;
        }
        
        $this->response->setStatus(true)->setData($return)->out();

    }
    
     public function permissiontree($groupId) {

        $data = file_get_contents(PATH . '/resources/permission/methods.json');
        $data = json_decode($data);

        
        $return = [];
        $tmp    = null;
        $index  = -1;
        
        foreach ($data as $d) {
            
            if($tmp == null || $tmp != $d->tag){
                $tmp = $d->tag;
                $index++;
                $return[$index] = ['name' => $d->tag , 'children' => []];
                 
            }
         
            $upd = [
                'name' => ' '.$d->tag,
                'path' => $d->path,
                'get' => [
                    'available' => in_array('get', $d->methods),
                    'active'    => Permission::where(['method' => 'get', 'route' => $d->path, 'group_id' => $groupId])->first() != null
                ],
                'post' => [
                    'available' => in_array('post', $d->methods),
                    'active'    => Permission::where(['method' => 'post', 'route' => $d->path, 'group_id' => $groupId])->first() != null
                ],
                'put' => [
                    'available' => in_array('put', $d->methods),
                    'active'    => Permission::where(['method' => 'put', 'route' => $d->path, 'group_id' => $groupId])->first() != null
                ],
                'delete' => [
                    'available' => in_array('delete', $d->methods),
                    'active'    => Permission::where(['method' => 'delete', 'route' => $d->path, 'group_id' => $groupId])->first() != null
                ]
            ];
            
            if($tmp == $d->tag){
                array_push($return[$index]['children'],$upd);
            }else{
                
            }
            
         //   $return[] = $upd;
        }
        
        $this->response->setStatus(true)->setData($return)->out();

    }
    
    public function updatePermission($groupId) {
        
        if(empty($groupId)){
            return false;
        }
        
        $data = \Helper\Input::json();

        $this->validation->validate([
            'route'     => 'required',
            'method'    => 'required',
            //'active'    => 'required'
        ]);
        
        $data->active = (int) $data->active;

        if ($this->validation->hasError()) {
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Permission::where(['method' => $data->method, 'route' => $data->route, 'group_id' => $groupId])->first();

        if ($data->active == 1) {

            if ($record == null) {             
                $record              = new Permission();
                $record->group_id    = $groupId;
                $record->route       = $data->route;
                $record->method      = $data->method;
                $record->save();
            }
            
        }else{
            
            if($record != null){
                $record->delete();
            }
        }
        
        $this->response->setStatus(true)->out();
    }

}
