<?php

namespace Application\Api\Notification;

use Core\Base\Webservice;
use Model\Notification\Mail as Model; 
use Model\Notification\Template;
use Model\Localization\Language;
use Model\Notification\NotificationView;

class Mail extends Webservice {

    public $templateId;
    public $view;
    
    public function __construct() {
        parent::__construct();
        $this->view = new NotificationView();
    }
    
    public function get() {
        
         try{
            
            $parent = Template::find($this->templateId)->toArray();
            $parent['parameters'] = [];// $this->view->params();
            
            $data   = $this->getLanguageContent($this->templateId);
            $this->response->setStatus(true)->setMeta([])->setParent($parent)->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
    public function store() {
        echo __METHOD__;
    }
    
    public function update() {
        
        $data     = \Helper\Input::json();
        
        $this->validation->validate([
            'subject'  => 'required',
            'message'  => 'required',
            'language' => 'required'
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
       
        $record = Model::where(['template_id' => $this->templateId , 'language' => $data->language])->first();
        if($record == NULL){
            $record = new Model;
            $record->template_id    = $this->templateId;
            $record->language       = $data->language;
        }
                
        $record->subject      = isset($data->subject)  ? $data->subject : $record->subject;
        $record->message      = isset($data->message)  ? $data->message : $record->message;
        $record->save();
                
        $this->response->setStatus(true)->out();
    }
    
    public function show($id = 0) {
        echo __METHOD__;
    }
    
    public function destroy($id = 0) {
        echo __METHOD__;
    }     
    
    // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'language_name' => $language->name, 'subject' => '', 'message' => ''  , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = Model::where(['template_id' => $id , 'language' => $language->code])->first();
            if($translate!= NULL) {
                $add['subject']    = $translate->subject;
                $add['message']    = $translate->message;
            }
            
            array_push($return,$add);
        }
        
        return $return;        
    }
}
