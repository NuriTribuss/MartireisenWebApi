<?php

namespace Application\Api\Landing;

use Core\Base\Webservice;
use Model\Landing\Base as Model; 
use Model\Landing\BaseTranslation;
use Model\Localization\Language; 
use Model\Link\Link;

class Base extends Webservice {

    private   $linkModel = null;

    public function __construct() {
        parent::__construct();
        
        $this->linkModel = new Link();
        $this->linkModel->setType('landing');
    }
    
    public function get() {
        
         try{
             
            $model = Model::whereRaw('1 = 1');
            $pagination = [
                'page'  => \Helper\Input::get('page',1)
            ];
                        
            $skip                   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $pagination['total']    = $model->with('translate')->whereHas('translate' , $this->filterTranslate())->count();
            
            $data   = $model->skip($skip)->take($this->limit)->get();
                      
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
        
        $this->linkModel->setUrl($data->url,$data->name);
        
        $language = $this->linkModel->getLanguage();
        
        if($this->linkModel->exists()){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $record = new Model;
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number : 999;
        $record->active      = isset($data->active) ? (int)$data->active : 1;
        $record->related_ids = isset($data->related_ids) ? (string)$data->related_ids : '';

        $record->save();
        $record->code = 'PA'.$record->id;
        $record->save();
        
        $pageTranslation = new PageTranslation();
        $pageTranslation->language = $language;
        $pageTranslation->page_id = $record->id;
        $pageTranslation->name     = $data->name;
        $pageTranslation->content  = (string)$data->content;
        $pageTranslation->url      = $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->save(['table_id' => $record->id]);

        $this->response->setStatus(true)->setData(['id' => $record->id , 'action' => 'insert'])->out();
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
        
        if(!empty($data->url)){
            $this->linkModel->setEmptyUrl();
        }
        
        $language = $this->linkModel->getLanguage();
        
       // if($this->linkModel->exists($id)){
         //   $this->response->http(400)->setMessage('This Link is aldready exists')->out();
      //  }
        
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number :  $record->sort_number;
        $record->active      = isset($data->active) ? (int)$data->active : $record->active;
        $record->related_ids = isset($data->related_ids) ? (string)$data->related_ids : $record->related_ids;

        $record->save();
        
        
        $pageTranslation = BaseTranslation::where(['base_id' => $id,'language' => $language])->first();
        if($pageTranslation == NULL){
            $pageTranslation = new BaseTranslation();
            $pageTranslation->base_id = $record->id;
        }
        
        $pageTranslation->language          = $language;
        $pageTranslation->title             = isset($data->title) ? $data->title :  $pageTranslation->title;
        $pageTranslation->subtitle          = isset($data->subtitle) ? $data->subtitle :  $pageTranslation->subtitle;
        $pageTranslation->second_title      = isset($data->second_title) ? $data->second_title :  $pageTranslation->second_title;
        $pageTranslation->second_subtitle   = isset($data->second_subtitle) ? $data->second_subtitle :  $pageTranslation->second_subtitle;
        $pageTranslation->third_title       = isset($data->third_title) ? $data->third_title :  $pageTranslation->third_title;
        $pageTranslation->third_subtitle    = isset($data->third_subtitle) ? $data->third_subtitle :  $pageTranslation->third_subtitle;
        $pageTranslation->content           = isset($data->content) ? $data->content :  $pageTranslation->content;
     //   $pageTranslation->url               = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id]);

        $this->response->setStatus(true)->out();
    }
    
    public function translate($pageId =0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'title'     => 'required',
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
        
        $this->linkModel->setLanguage($data->language);
        $this->linkModel->setEmptyUrl();
        
       // if($this->linkModel->exists($pageId,$data->language)){
       //     $this->response->http(400)->setMessage('This Link is aldready exists')->out();
      //  }
        
        $pageTranslation = BaseTranslation::where(['base_id' => $pageId,'language' => $data->language])->first();
        
        if($pageTranslation == NULL){
            $pageTranslation = new BaseTranslation();
            $pageTranslation->base_id = $record->id;
            $pageTranslation->language = $data->language;
        }
        
        $pageTranslation->title             = isset($data->title) ? $data->title :  $pageTranslation->title;
        $pageTranslation->subtitle          = isset($data->subtitle) ? $data->subtitle :  $pageTranslation->subtitle;
        $pageTranslation->second_title      = isset($data->second_title) ? $data->second_title :  $pageTranslation->second_title;
        $pageTranslation->second_subtitle   = isset($data->second_subtitle) ? $data->second_subtitle :  $pageTranslation->second_subtitle;
        $pageTranslation->third_title       = isset($data->third_title) ? $data->third_title :  $pageTranslation->third_title;
        $pageTranslation->third_subtitle    = isset($data->third_subtitle) ? $data->third_subtitle :  $pageTranslation->third_subtitle;
        $pageTranslation->content           = isset($data->content) ? $data->content :  $pageTranslation->content;
       // $pageTranslation->url               = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id], true);
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
    
    public function fetch() {
        
        $code = \Helper\Input::get('code','');
        $page  = Model::where('code',$code)->first();
        
        if($page != NULL){
            
            $this->linkModel->setType('landing_'.$page->type);
            
            $return = $page->toArray();
            $return['translate'] = $this->getLanguageContent($page->id,$page->code,$page->type);
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
        
        BaseTranslation::where('base_id',$id)->delete();
        $this->response->setStatus(true)->out();
    }   

    public function filterTranslate() {
        
        $params = $_GET;
        
        return function ($q) use ($params){
            
            $q->where('language', $this->language);
            if(!empty($params['name'])){
                $q->where('title', 'LIKE','%'.$params['name'].'%');
            }
            if(!empty($params['url'])){
                $q->where('url', 'LIKE','%'.$params['url'].'%');
            }
            
       };
    }
    
    // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '', 'content' => '' ,'url' => '' , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = BaseTranslation::where(['base_id' => $id , 'language' => $language->code])->first();
            
            if($translate!= NULL) {
                $add['title']               = $translate->title;
                $add['subtitle']            = $translate->subtitle;
                $add['second_title']        = $translate->second_title;
                $add['second_subtitle']     = $translate->second_subtitle;
                $add['third_title']         = $translate->third_title;
                $add['third_subtitle']      = $translate->third_subtitle;
                $add['content']             = $translate->content;
                $add['url']                 = $translate->url;
            }
            
            $add['meta']    = $this->linkModel->getMeta(['table_id' => $id , 'language' => $language->code]);

            array_push($return,$add);
        }
        
        return $return;        
    }
}
