<?php

namespace Application\Api\Sys;

use Core\Base\Webservice;
use Illuminate\Database\Capsule\Manager as DB;
use Model\Link as Model;

class Link extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
             
            $model = $this->build(Model::whereRaw('1 = 1'));
            $model = $this->filter($model);

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
        echo __METHOD__;
    }
    
    public function update($id = 0) {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'title' => 'required',
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
        
        $record->title          = isset($data->title) ? $data->title :  $record->title;
        $record->description    = isset($data->description) ? $data->description : $record->description;
        $record->keywords       = isset($data->keywords) ? $data->keywords : $record->keywords;
        $record->save();
        
        // link güncelleme
        if(isset($data->value) && !empty($data->value)){
            
            $link = \Helper\Url::beautify($data->value);
            if($record->value != $link){
                
                $linkModel = new LinkModel;
                $linkModel->setUrl($link);
                
                // to do 301
                $exits = $linkModel->exists($record->table_id, $record->locale);
                if($exits === false){
                    $record->value = $data->value;
                    $record->save();
                    $this->tableUpdate($record,$data->value);
                }else{
                    $this->response->setMessage('This Link is aldready exists')->out();
                }
                
            }
        }
        
        $this->response->setStatus(true)->out();
    }
    
    private function tableUpdate($record,$url) {
        
        $table = [
            'content/page'  => [
                'table'     => 'content__page_translation',
                'column'    => 'page_id'
            ],
            'content/post'  => [
                'table'     => 'content__post_translation',
                'column'    => 'post_id'
            ],
            'content/post-category'  => [
                'table'     => 'content__post_category_translation',
                'column'    => 'category_id'
            ],
            'content/support'  => [
                'table'     => 'supportcenter_translation',
                'column'    => 'support_id'
            ],
            'content/support-category'  => [
                'table'     => 'supportcenter_category_translation',
                'column'    => 'category_id'
            ],
            'landing_hotel'  => [
                'table'     => 'landing__otel_translation',
                'column'    => 'otel_id'
            ],
           
          //  'system'
        ];
        if(!isset($table[$record->type]['table'])){
            return true;
        }
        DB::table($table[$record->type]['table'])->where(['language' => $record->language , $table[$record->type]['column'] => $record->table_id])->update(['url' => $url]);
        return true;
    }
    
    public function show($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }    
        $this->response->setStatus(true)->setData($record->toArray())->out();
    }
    
    public function destroy($id = 0) {
        echo __METHOD__;
    }     
    
        
    private function filter($entity){
        
        $params = $_GET;
        
        if(!empty($params['title'])){
            $entity = $entity->where('title','LIKE', $params['title'].'%');
        }   
        
        if($params['extra'] === 'empty_seo'){
            $entity = $entity->where('title','=', '');
        }   
        
        if(!empty($params['value'])){
            $entity = $entity->where('value','LIKE', $params['value'].'%');
        }               
        
        if(!empty($params['language'])){
             $entity = $entity->where('language',$params['language']);
        }
        
        if(!empty($params['type'])){
             $entity = $entity->where('type',$params['type']);
        }
        
        return $entity;
    }
    
    public function addRedirect() {
        
        $data = \Helper\Input::json();

        $this->validation->validate([
            'value' => 'required',
            'redirect_value' => 'required',
        ]);

        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        } 
        
        $record = Model::where('value', $data->redirect_value)->first();
        
        if($record == NULL){
             $this->response->setMessage('Redirect Value Not Found')->out();
        }
        
        $new = new Model();
        
        $new->value = $data->value;
        $new->redirect_value = $data->redirect_value;
        $new->type = '301';
        
        $new->save();
        
        $this->response->setStatus(true)->out();
    }
}
