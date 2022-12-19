<?php

namespace Application\Api\Design\Menu;

use Core\Base\Webservice;

use Model\Design\Menu\Category as Model;
use Model\Design\Menu\CategoryTranslation;
use Model\Design\Menu\CategoryView;
use Model\Localization\Language;
use Core\Cache\RedisCache;

class Category extends Webservice {

    private $menuId;
    private $cache;
    
    public function __construct($menuId = NULL) {  
        parent::__construct();
        
        $this->menuId = $menuId;
        
        if($this->menuId == NULL){
            $this->response->setMessage('Menu ıd requried')->out();
        }
    
        $this->cache = RedisCache::getInstance();
    }
    
    public function get($parentId = 0) {
        
         try{
            
            $model = $this->build(Model::where(['menu_id' => $this->menuId,'parent' => (int)$parentId]));
            
            $this->limit = 25;
            
            $data   = $model->with(['translate' => function($q) {
                $q->where('language',$this->language);
            }])->skip(0)->take($this->limit)->get();
            
            if($parentId > 0){
                $parent = Model::find($parentId);
                $this->response->setParent($parent);
            }else{
                $parent = \Model\Design\Menu\MenuTranslation::where(['menu_id' => $this->menuId])->first();
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
        $categoryModel->menuId = $this->menuId;
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
        
        $language = $this->language;
        
        if((int)$data->parent > 0 ){
            $parentRecord  = Model::find($data->parent);
            if($parentRecord === NULL){
                $this->response->http(400)->setMessage('Parent Category Not Found')->out();
            }
        }
        
        try {
            
            $categoryModel = new \Core\Structure\Category();
            $categoryModel->setEntity(new Model);
            $categoryModel->menuId = $this->menuId;

            $categoryData = (array)$data;
            
            $categoryData['type']           = (int) $data->type;
            $categoryData['type_table_id']  = (int) $data->type_table_id;
            $categoryData['icon_class']  = (string) $data->icon_class;
            $categoryData['icon_color']  = (string) $data->icon_color;

            unset($categoryData['name'],$categoryData['url'],$categoryData['description']);

            $id = $categoryModel->add($categoryData);

            $categoryTranslation = new CategoryTranslation();
            $categoryTranslation->language    = $language;
            $categoryTranslation->category_id = $id;
            $categoryTranslation->name        = $data->name;
            $categoryTranslation->description = (string)$data->description;
            $categoryTranslation->url         = (string)$data->url;
            $categoryTranslation->save();
            
            if($parentRecord != NULL && $parentRecord->has_children != 1){
                $parentRecord->has_children = 1;
                $parentRecord->save();
            }
            
            $this->cache->clear();
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
        
        $language = $this->language;
        $record->sort_number    = isset($data->sort_number) ? (int)$data->sort_number :  $record->sort_number;
        $record->type           = isset($data->type) ? (int)$data->type :  $record->type;
        $record->type_table_id  = isset($data->type_table_id) ? (int)$data->type_table_id :  $record->type_table_id;
        $record->icon_class     = isset($data->icon_class) ? (string)$data->icon_class :  $record->icon_class;
        $record->icon_color     = isset($data->icon_color) ? (string)$data->icon_color :  $record->icon_color;
        
        $record->active         = isset($data->active) ? (int)$data->active : $record->active;
        $record->save();
        
        
        $categoryTranslation = CategoryTranslation::where(['category_id' => $id,'language' => $language])->first();
        if($categoryTranslation == NULL){
            $categoryTranslation = new CategoryTranslation();
            $categoryTranslation->category_id = $record->id;
        }
        
        $categoryTranslation->language = $language;
        $categoryTranslation->name     = isset($data->name) ? $data->name :  $categoryTranslation->name;
        $categoryTranslation->description     = isset($data->description) ? $data->description :  $categoryTranslation->description;

        $categoryTranslation->url      =  isset($data->url) ? $data->url :  $categoryTranslation->url;
        $categoryTranslation->save();
        $this->cache->clear();
        
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
        
        $categoryTranslation = CategoryTranslation::where(['category_id' => $categoryId,'language' => $data->language])->first();
        
        if($categoryTranslation == NULL){
            $categoryTranslation = new CategoryTranslation();
            $categoryTranslation->category_id = $record->id;
            $categoryTranslation->language = $data->language;
        }
        
        $categoryTranslation->name          = isset($data->name) ? $data->name :  $categoryTranslation->name;
        $categoryTranslation->description   = isset($data->description) ? $data->description :  $categoryTranslation->description;
        $categoryTranslation->url           = isset($data->url) ? $data->url :  $categoryTranslation->url;

        $categoryTranslation->save();
        $this->cache->clear();
        $this->response->setStatus(true)->out();
        
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $category  = Model::find($id);
        
        if($category != NULL){
            
            $return = $category->toArray();
            $return['translate'] = $this->getLanguageContent($category->id);
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
        $categoryModel->menuId = $this->menuId;

        $categoryModel->delete();
        $this->cache->clear();
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
            
            array_push($return,$add);
        }
        
        return $return;        
    }
    
    public function options($id = NULL) {
        
        $categoryView = new CategoryView();
        $types        = $categoryView->getOptions();
       
        $this->response->setStatus(true)->setData($types)->out();
    }
}
