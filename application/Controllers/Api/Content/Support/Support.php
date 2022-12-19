<?php

namespace Application\Api\Content\Support;

use Core\Base\Webservice;

use Model\Content\Support\Support as Model;
use Model\Content\Support\SupportTranslation;
use Model\Content\Support\SupportHierarchy;
use Model\Localization\Language;
use Model\Content\Support\Category;
use Model\Link\Link;

class Support extends Webservice {

    private   $linkModel = null;

    public function __construct() {
        parent::__construct();
        
        $this->linkModel = new Link();
        $this->linkModel->setType('content/support');
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
            'name'       => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $this->linkModel->setUrl($data->url,$data->name);
        
        $language = $this->linkModel->getLanguage();
           
        if($this->linkModel->exists()){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $record = new Model;
        $record->sort_number  = isset($data->sort_number) ? (int)$data->sort_number : 999;
        $record->active       = isset($data->active) ? (int)$data->active : 1;        

        $record->save();
        $record->code = 'MS'.$record->id;
        $record->save();
        
      
        // category
        if(is_array($data->categories) && count($data->categories) > 0 ){
            
            foreach($data->categories as $category){
                $find = Category::find($category);
                if($find == NULL){
                    continue;
                }
                $hierarchy = new SupportHierarchy();
                $hierarchy->support_id  = $record->id;
                $hierarchy->category_id = $category;
                $hierarchy->save();
            }
            
        }
        
        $supportTranslation = new SupportTranslation();
        $supportTranslation->language     = $language;
        $supportTranslation->support_id   = $record->id;
        $supportTranslation->name         = $data->name;
        $supportTranslation->content      = (string)$data->content;
        $supportTranslation->url          = $this->linkModel->getUrl();
        $supportTranslation->save();
        
        $this->linkModel->save(['table_id' => $record->id]);

        $this->response->setStatus(true)->setData(['id' => $record->id , 'action' => 'insert'])->out();
    }
    
    public function update($id = 0) {
        
               
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name'       => 'required',
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
        
        if(!empty($data->url)){
            $this->linkModel->setUrl($data->url,$data->name);
        }
        
        $language = $this->linkModel->getLanguage();
        
        if($this->linkModel->exists($id)){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $record->sort_number  = isset($data->sort_number) ? (int)$data->sort_number : $record->sort_number;
        $record->active       = isset($data->active) ? (int)$data->active : $record->active;
        $record->save();
        
         // category
        if(is_array($data->categories) && count($data->categories) > 0 ){
            
            $hierarchies = SupportHierarchy::where(['support_id' => $record->id])->get();
            if($hierarchies == NULL){
                $hierarchies = [];
            }else{
                $hierarchies = array_column($hierarchies->toArray() , 'category_id');
            }
            
            foreach($data->categories as $category){
                
                $find = Category::find($category);
                if($find == NULL || in_array($category, $hierarchies)){
                    continue;
                }
                
                $hierarchy = new SupportHierarchy();
                $hierarchy->support_id  = $record->id;
                $hierarchy->category_id = $category;
                $hierarchy->save();
            }
            
            foreach($hierarchies as $hierarchy){
                if(!in_array($hierarchy, $data->categories)){
                    SupportHierarchy::where(['support_id' => $record->id , 'category_id' => $hierarchy])->delete();
                }
            }
        }
        
        
        $supportTranslation = SupportTranslation::where(['support_id' => $id,'language' => $language])->first();
        if($supportTranslation == NULL){
            $supportTranslation = new SupportTranslation();
            $supportTranslation->support_id = $record->id;
        }
        
        $supportTranslation->language = $language;
        $supportTranslation->name     = isset($data->name) ? $data->name :  $supportTranslation->name;
        $supportTranslation->content  = isset($data->content) ? $data->content :  $supportTranslation->content;
        $supportTranslation->url      = $this->linkModel->getUrl() == NULL ? $supportTranslation->url : $this->linkModel->getUrl();
        $supportTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id]);

        $this->response->setStatus(true)->out();
    }
    
    public function translate($supportId =0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name'     => 'required',
            'language' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($supportId);
        
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if(strlen($data->language) != 2 ){
             $this->response->setMessage('Language Not Found')->out();
        }
        
        $this->linkModel->setLanguage($data->language);
        
        if(!isset($data->url) || !empty($data->url)){
            $this->linkModel->setUrl($data->url,$data->name);
        }
        
        if($this->linkModel->exists($supportId,$data->language)){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $supportTranslation = SupportTranslation::where(['support_id' => $supportId,'language' => $data->language])->first();
        
        if($supportTranslation == NULL){
            $supportTranslation = new SupportTranslation();
            $supportTranslation->support_id = $record->id;
            $supportTranslation->language = $data->language;
        }
        
        $supportTranslation->name        = isset($data->name) ? $data->name :  $supportTranslation->name;
        $supportTranslation->content     = isset($data->content) ? $data->content :  $supportTranslation->content;

        $supportTranslation->url      = $this->linkModel->getUrl() == NULL ? $supportTranslation->url : $this->linkModel->getUrl();
        $supportTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id], true);
        $this->response->setStatus(true)->out();
        
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $support  = Model::find($id);
        
        if($support != NULL){
            
            $return = $support->toArray();
            $return['categories'] = array_column(SupportHierarchy::where(['support_id' => $id])->get()->toArray() , 'category_id');
            $return['translate']  = $this->getLanguageContent($support->id);
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
        
        $this->linkModel->delete(['table_id' => $id]);
        SupportTranslation::where('support_id',$id)->delete();
        $this->response->setStatus(true)->out();
    }  
    
     // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '', 'content' => '','url' => '' , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = SupportTranslation::where(['support_id' => $id , 'language' => $language->code])->first();
            if($translate!= NULL) {
                $add['name'] = $translate->name;
                $add['url']  = $translate->url;
                $add['content']  = $translate->content;
            }
            
            $add['meta']    = $this->linkModel->getMeta(['table_id' => $id , 'language' => $language->code]);

            array_push($return,$add);
        }
        
        return $return;        
    }
    
}
