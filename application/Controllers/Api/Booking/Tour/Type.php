<?php


namespace Application\Api\Booking\Tour;

use Core\Base\Webservice;
use Model\Tour\Type as Model;
use Model\Link\Link;
use Model\Localization\Language;

class Type extends Webservice {
    
    private $linkModel;
    
    public function __construct() {
        parent::__construct();
        
        $this->linkModel = new Link();
        $this->linkModel->setType('tour_type');
    }
    
    public function get() {
        
         try{
             
            $model = $this->build(Model::whereRaw('1=1'));
            $pagination = [
                'total' => $model->count(),
                'page'  => \Helper\Input::get('page',1)
            ];
            
            $skip   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $data   = $model->with(['translate' => function($q) {
                $q->where('language',$this->language);
            }])->skip($skip)->take($this->limit)->get();
            
        
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data->toArray())->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }    
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $record = Model::find($id);
        
        if($record != NULL){
            
            $return   = $record->toArray();
            $return['translate'] = $this->getLanguageContent($id);
            $this->response->setStatus(true)->setData($return)->out();
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
        
        if($this->linkModel->exists()){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $record = new Model;
        $record->save();
        
        $record->code = 'TYPE_'.$record->id;
        $record->save();
        
        $pageTranslation = new \Model\Tour\TypeTranslation();
        $pageTranslation->language      = $this->language;
        $pageTranslation->type_id       = $record->id;
        $pageTranslation->name          = $data->name;
        $pageTranslation->url           = $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->save(['table_id' => $record->id , 'route' => 'tour/type']);

        $this->response->setStatus(true)->setData(['id' => $record->id , 'action' => 'insert'])->out();
    }
    
    public function update($id = 0) {
        
        $data = \Helper\Input::json();        
        
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
        
        if($this->linkModel->exists($id)){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $pageTranslation = \Model\Tour\TypeTranslation::where(['type_id' => $id,'language' => $this->language])->first();
        if($pageTranslation == NULL){
            $pageTranslation = new \Model\Tour\TypeTranslation();
            $pageTranslation->type_id = $record->id;
        }
        
        $pageTranslation->language      = $this->language;
        $pageTranslation->name          = isset($data->name) ? $data->name :  $pageTranslation->name;
        $pageTranslation->url           = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id , 'route' => 'tour/type']);

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
        
        $pageTranslation = \Model\Tour\TypeTranslation::where(['type_id' => $pageId,'language' => $data->language])->first();
        
        if($pageTranslation == NULL){
            $pageTranslation = new \Model\Tour\TypeTranslation();
            $pageTranslation->type_id = $record->id;
            $pageTranslation->language = $data->language;
        }
        
        $pageTranslation->name          = isset($data->name) ? $data->name :  $pageTranslation->name;
        $pageTranslation->url           = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id , 'route' => 'tour/type'], true);
        $this->response->setStatus(true)->out();
        
    }
    
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->delete();
        \Model\Tour\TypeTranslation::where('type_id',$id)->delete();
        
        $this->linkModel->delete(['table_id' => $id]);
        $this->response->setStatus(true)->out();
    }    
    
     // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '' , 'url' => '', 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = \Model\Tour\TypeTranslation::where(['type_id' => $id , 'language' => $language->code])->first();
            
            if($translate!= NULL) {
                $add['name']        = $translate->name;
                $add['url']         = $translate->url;
            }
            array_push($return,$add);
        }
        
        return $return;        
    } 
    
}
