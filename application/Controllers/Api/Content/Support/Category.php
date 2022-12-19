<?php

namespace Application\Api\Content\Support;

use Core\Base\Webservice;

use Model\Content\Support\Category as Model;
use Model\Content\Support\CategoryTranslation;
use Model\Localization\Language;
use Model\Link\Link;

class Category extends Webservice {
    
    private $linkModel;

    public function __construct() {  
        
        parent::__construct();
        $this->linkModel = new Link();
        $this->linkModel->setType('content/support-category');
    }
    
    public function get($parentId = 0) {
        
         try{
            
            $model = $this->build(Model::where('parent',$parentId));
            
            $this->limit = 25;
            
            $data   = $model->with(['translate' => function($q) {
                $q->where('language',$this->language);
            }])->skip(0)->take($this->limit)->get();
            
            if($parentId > 0){
                $parent = Model::find($parentId);
                $this->response->setParent($parent);
            }
            
            $this->response->setStatus(true)->setMeta([])->setData($data->toArray())->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
    public function tree() {
       
        $categoryModel = new \Core\Structure\Category();
        $categoryModel->setEntity(new Model);
        $tree =  $categoryModel->getTree();
     
        $this->response->setStatus(true)->setMeta([])->setData($tree)->out();
    }
    
    
    public function children($parentId = 0) {
        return $this->get($parentId);
    }
    
    public function store() {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $this->linkModel->setUrl($data->url,$data->name);
        $language = $this->linkModel->getLanguage();
        
        if($this->linkModel->exists()){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        if((int)$data->parent > 0 ){
            $parentRecord  = Model::find($data->parent);
            if($parentRecord === NULL){
                $this->response->http(400)->setMessage('Parent Category Not Found')->out();
            }
        }
        
        try {
            
            $categoryModel = new \Core\Structure\Category();
            $categoryModel->setEntity(new Model);
            $categoryData = (array)$data;
            
            unset($categoryData['name'],$categoryData['url'],$categoryData['description'],$categoryData['meta']);

            $id = $categoryModel->add($categoryData);

            $categoryTranslation = new CategoryTranslation();
            $categoryTranslation->language    = $language;
            $categoryTranslation->category_id = $id;
            $categoryTranslation->name        = $data->name;
            $categoryTranslation->description = (string)$data->description;
            $categoryTranslation->url         = $this->linkModel->getUrl();
            $categoryTranslation->save();

            $this->linkModel->save(['table_id' => $id]);
            
            if($parentRecord != NULL && $parentRecord->has_children != 1){
                $parentRecord->has_children = 1;
                $parentRecord->save();
            }
            
        $this->response->setStatus(true)->setData(['id' => $id , 'action' => 'insert'])->out();

        }catch(\Exception $e){
            $this->response->http(400)->setStatus(false)->setMessage('Bad Request '.$e->getMessage())->out();
        }

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
        
        $link = new Link();
        $link->setType('module/support-category');
        
        if(!empty($data->url)){
            $link->setUrl($data->url,$data->name);
        }
        
        $language = $link->getLanguage();
        
        if($link->exists($id)){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number :  $record->sort_number;
        $record->active      = isset($data->active) ? (int)$data->active : $record->active;
        $record->save();
        
        
        $categoryTranslation = CategoryTranslation::where(['category_id' => $id,'language' => $language])->first();
        if($categoryTranslation == NULL){
            $categoryTranslation = new CategoryTranslation();
            $categoryTranslation->category_id = $record->id;
        }
        
        $categoryTranslation->language = $language;
        $categoryTranslation->name     = isset($data->name) ? $data->name :  $categoryTranslation->name;
        $categoryTranslation->description     = isset($data->description) ? (string)$data->description :  $categoryTranslation->description;

        $categoryTranslation->url      = $link->getUrl() == NULL ? $categoryTranslation->url : $link->getUrl();
        $categoryTranslation->save();
        
        $link->update(['table_id' => $record->id]);

        $this->response->setStatus(true)->out();
    }
    
    public function translate($categoryId =0) {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name'     => 'required',
            'language' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($categoryId);
        
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if(strlen($data->language) != 2 ){
             $this->response->setMessage('Language Not Found')->out();
        }
        
        $this->linkModel->setLanguage($data->language);
        $this->linkModel->setUrl($data->url,$data->name);
        
        if($this->linkModel->exists($categoryId,$data->language)){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $categoryTranslation = CategoryTranslation::where(['category_id' => $categoryId,'language' => $data->language])->first();
        
        if($categoryTranslation == NULL){
            $categoryTranslation = new CategoryTranslation();
            $categoryTranslation->category_id = $record->id;
            $categoryTranslation->language = $data->language;
        }
        
        $categoryTranslation->name     = isset($data->name) ? $data->name :  $categoryTranslation->name;
        $categoryTranslation->description     = isset($data->description) ? $data->description :  (string)$categoryTranslation->description;
        $categoryTranslation->url      = $this->linkModel->getUrl() == NULL ? $categoryTranslation->url : $this->linkModel->getUrl();
        $categoryTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id], true);
        $this->response->setStatus(true)->out();
        
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $brand  = Model::find($id);
        
        if($brand != NULL){
            
            $return = $brand->toArray();
            $return['translate'] = $this->getLanguageContent($brand->id);
            $this->response->setStatus(true)->setData($return)->out();
        }
        
        $this->response->out();
    }
    
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $categoryModel = new \Core\Structure\Category();
        $categoryModel->setEntity($record);
        $categoryModel->delete();
     //   $record->delete();
        $this->response->setStatus(true)->out();
    }  
    
    
    // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '', 'description' => '','url' => '' , 'description' => '' , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = CategoryTranslation::where(['category_id' => $id , 'language' => $language->code])->first();
            if($translate!= NULL) {
                $add['name'] = $translate->name;
                $add['description'] = $translate->description;
                $add['url']  = $translate->url;
            }
            $add['meta']    = $this->linkModel->getMeta(['table_id' => $id , 'language' => $language->code]);

            array_push($return,$add);
        }
        
        return $return;        
    }
}
