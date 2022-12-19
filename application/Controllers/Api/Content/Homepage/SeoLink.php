<?php

namespace Application\Api\Content\Homepage;

use Core\Base\Webservice;
use Model\Content\Homepage\Seo\Link as Model;
use Model\Content\Homepage\Seo\LinkTranslation;
use Model\Localization\Language; 

class SeoLink extends Webservice {

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
            
            $data   = $model->with(['translate' => function($q) {
                $q->where('language',$this->language);
            }])->skip($skip)->take($this->limit)->get();
            
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
        
        $language = $this->language;
        
        $record = new Model;
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number : 999;
        $record->active      = isset($data->active) ? (int)$data->active : 1;
        $record->save();
        
        $pageTranslation = new LinkTranslation();
        $pageTranslation->language = $language;
        $pageTranslation->link_id = $record->id;
        $pageTranslation->name     = $data->name;
        $pageTranslation->url  = (string)$data->url;
        $pageTranslation->save();
        

        $this->response->setStatus(true)->setData(['id' => $record->id , 'action' => 'insert'])->out();
    }
    
    
    public function update($id = 0) {
        
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
   
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $language = $this->language;
        
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number :  $record->sort_number;
        $record->active      = isset($data->active) ? (int)$data->active : $record->active;
        $record->save();
        
        
        $pageTranslation = LinkTranslation::where(['link_id' => $id,'language' => $language])->first();
        if($pageTranslation == NULL){
            $pageTranslation = new LinkTranslation();
            $pageTranslation->link_id = $record->id;
        }
        
        $pageTranslation->language = $language;
        $pageTranslation->name     = isset($data->name) ? $data->name :  $pageTranslation->name;
        $pageTranslation->url  = isset($data->url) ? $data->url :  $pageTranslation->url;
        $pageTranslation->save();

        $this->response->setStatus(true)->out();
    }
    
    public function translate($pageId =0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name'     => 'required',
            'language' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($pageId);
        
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if(strlen($data->language) != 2 ){
             $this->response->setMessage('Language Not Found')->out();
        }
        
        $pageTranslation = LinkTranslation::where(['link_id' => $pageId,'language' => $data->language])->first();
        
        if($pageTranslation == NULL){
            $pageTranslation = new LinkTranslation();
            $pageTranslation->link_id = $record->id;
            $pageTranslation->language = $data->language;
        }
        
        $pageTranslation->name     = isset($data->name) ? $data->name :  $pageTranslation->name;
        $pageTranslation->url  = isset($data->url) ? $data->url :  $pageTranslation->url;
        $pageTranslation->save();
        
        $this->response->setStatus(true)->out();
        
    }
    
    public function show($id = 0) {
       
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $page  = Model::find($id);
        
        if($page != NULL){
            
            $return = $page->toArray();
            $return['translate'] = $this->getLanguageContent($page->id);
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
        
        LinkTranslation::where('link_id',$id)->delete();
        $this->response->setStatus(true)->out();
    }     
    
    // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '', 'url' => '' , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = LinkTranslation::where(['link_id' => $id , 'language' => $language->code])->first();
            if($translate!= NULL) {
                $add['name']    = $translate->name;
                $add['url'] = $translate->url;
            }

            array_push($return,$add);
        }
        
        return $return;        
    }
}
