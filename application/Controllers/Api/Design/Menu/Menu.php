<?php

namespace Application\Api\Design\Menu;

use Core\Base\Webservice;
use Model\Design\Menu\Menu as Model;
use Model\Design\Menu\MenuTranslation;
use Model\Localization\Language;

class Menu extends Webservice {

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
            //$data   = $model->skip($skip)->take($this->limit)->get();
            
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data->toArray())->out();

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
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number : 999;
        $record->active      = isset($data->active) ? (int)$data->active : 1;
        $record->save();
        $record->code = 'MENU'.$record->id;
        $record->save();
        
        $menuTranslation = new MenuTranslation();
        $menuTranslation->language   = $this->language;
        $menuTranslation->menu_id    = $record->id;
        $menuTranslation->name       = $data->name;
        $menuTranslation->save();

        $this->response->setStatus(true)->setData(['id' => $record->id , 'action' => 'insert'])->out();
    }
    
    public function translate($menuId =0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name'     => 'required',
            'language' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($menuId);
        
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if(strlen($data->language) != 2 ){
             $this->response->setMessage('Language Not Found')->out();
        }   
        
        $menuTranslation = MenuTranslation::where(['menu_id' => $menuId,'language' => $data->language])->first();
        
        if($menuTranslation == NULL){
            $menuTranslation = new MenuTranslation();
            $menuTranslation->menu_id = $record->id;
            $menuTranslation->language = $data->language;
        }
        
        $menuTranslation->name     = isset($data->name) ? $data->name :  $menuTranslation->name;
     //   $menuTranslation->content  = isset($data->content) ? $data->content :  $menuTranslation->content;
        $menuTranslation->save();
        
        $this->response->setStatus(true)->out();
        
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
        
        
        $pageTranslation = MenuTranslation::where(['menu_id' => $id,'language' => $language])->first();
        if($pageTranslation == NULL){
            $pageTranslation = new MenuTranslation();
            $pageTranslation->page_id = $record->id;
        }
        
        $pageTranslation->language = $language;
        $pageTranslation->name     = isset($data->name) ? $data->name :  $pageTranslation->name;
      //  $pageTranslation->content  = isset($data->content) ? $data->content :  $pageTranslation->content;
        $pageTranslation->save();

        $this->response->setStatus(true)->out();
     
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        $return = NULL;
        $module  = Model::find($id);
        
        if($module != NULL){
            $return = $module->toArray();
            $return['translate'] = $this->getLanguageContent($id);

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
        \Model\Design\Menu\Category::where('menu_id',$id)->delete();
        $this->response->setStatus(true)->out();
    }     
    
    public function category($menuId , $id = null,$method = null) {

        $menu = new Category($menuId); 
        $menu->index($id,$method); 
    }
  
        // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '', 'content' => ''  , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = MenuTranslation::where(['menu_id' => $id , 'language' => $language->code])->first();
            if($translate!= NULL) {
                $add['name']    = $translate->name;
             //   $add['content'] = $translate->content;
            }
            
            array_push($return,$add);
        }
        
        return $return;        
    }
    
}
