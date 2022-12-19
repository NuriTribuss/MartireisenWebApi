<?php

namespace Application\Api\Content;

use Core\Base\Webservice;
use Model\Content\Page as Model; 
use Model\Content\PageTranslation;
use Model\Localization\Language; 
use Model\Link\Link;

class Page extends Webservice {

    private   $linkModel = null;

    public function __construct() {
        parent::__construct();
        
        $this->linkModel = new Link();
        $this->linkModel->setType('content/page');
    }
    // page
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
    // page post 
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
        $record->save();
        $record->code = 'PA'.$record->id;
        $record->save();
        
        $pageTranslation = new PageTranslation();
        $pageTranslation->language = $language;
        $pageTranslation->page_id = $record->id;
        $pageTranslation->name     = $data->name;
        $pageTranslation->content  = (string)$data->content;
        $pageTranslation->summary  = (string)$data->summary;

        $pageTranslation->name_a     = $data->name;
        $pageTranslation->content_a  = (string)$data->content;
        $pageTranslation->summary_a  = (string) $data->summary;
        $pageTranslation->url      = $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->save(['table_id' => $record->id]);

        $this->response->setStatus(true)->setData(['id' => $record->id , 'action' => 'insert'])->out();
    }
    
    // page put 
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
        
        if(!empty($data->url)){
            $this->linkModel->setUrl($data->url,$data->name);
        }
        
        $language = $this->linkModel->getLanguage();
        
        if($this->linkModel->exists($id)){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number :  $record->sort_number;
        $record->active      = isset($data->active) ? (int)$data->active : $record->active;
        $record->save();
        
        
        $pageTranslation = PageTranslation::where(['page_id' => $id,'language' => $language])->first();
        if($pageTranslation == NULL){
            $pageTranslation = new PageTranslation();
            $pageTranslation->page_id = $record->id;
        }
        
        $pageTranslation->language = $language;
        $pageTranslation->name     = isset($data->name) ? $data->name :  $pageTranslation->name;
        $pageTranslation->content  = isset($data->content) ? $data->content :  $pageTranslation->content;
        $pageTranslation->summary  = isset($data->summary) ? $data->summary :  $pageTranslation->summary;

        $pageTranslation->name_a     = isset($data->name_a) ? $data->name_a :  $pageTranslation->name_a;
        $pageTranslation->content_a  = isset($data->content_a) ? $data->content_a :  $pageTranslation->content_a;
        $pageTranslation->summary_a  = isset($data->summary_a) ? $data->summary_a :  $pageTranslation->summary_a;

        $pageTranslation->url      = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id]);

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
        
        $this->linkModel->setLanguage($data->language);
        $this->linkModel->setUrl($data->url,$data->name);
        
        if($this->linkModel->exists($pageId,$data->language)){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $pageTranslation = PageTranslation::where(['page_id' => $pageId,'language' => $data->language])->first();
        
        if($pageTranslation == NULL){
            $pageTranslation = new PageTranslation();
            $pageTranslation->page_id = $record->id;
            $pageTranslation->language = $data->language;
        }
        
        $pageTranslation->name     = isset($data->name) ? $data->name :  $pageTranslation->name;
        $pageTranslation->content  = isset($data->content) ? $data->content :  $pageTranslation->content;
        $pageTranslation->summary  = isset($data->summary) ? $data->summary :  $pageTranslation->summary;

        $pageTranslation->name_a     = isset($data->name_a) ? $data->name_a :  $pageTranslation->name_a;
        $pageTranslation->content_a  = isset($data->content_a) ? $data->content_a :  $pageTranslation->content_a;
        $pageTranslation->summary_a  = isset($data->summary_a) ? $data->summary_a :  $pageTranslation->summary_a;

        $pageTranslation->url      = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id], true);
        $this->response->setStatus(true)->out();
        
    }
    // page/1
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
    // page delete
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->delete();
        $this->linkModel->delete(['table_id' => $id]);
        
        PageTranslation::where('page_id',$id)->delete();
        $this->response->setStatus(true)->out();
    }     
    
    // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '', 'content' => '' ,'summary'=> '','url' => '' , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = PageTranslation::where(['page_id' => $id , 'language' => $language->code])->first();
            if($translate!= NULL) {
                $add['name']    = $translate->name;
                $add['content'] = $translate->content;
                $add['summary'] = $translate->summary;
                $add['url']     = $translate->url;
                
                $add['name_a']          = $translate->name_a;
                $add['content_a']       = $translate->content_a;
                $add['summary_a']       = $translate->summary_a;
            }
            $add['meta']    = $this->linkModel->getMeta(['table_id' => $id , 'language' => $language->code]);

            array_push($return,$add);
        }
        
        return $return;        
    }
}
