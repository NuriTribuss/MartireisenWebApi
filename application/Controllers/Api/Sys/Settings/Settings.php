<?php

namespace Application\Api\Sys\Settings;

use Core\Base\Webservice;
use Model\Sys\Settings\Setting as Model;
use Model\Sys\Settings\SettingTranslation;
use Model\Sys\Settings\Log;
use Model\Localization\Language;
use Model\Localization\Currency;
use Model\Region\Country;

class Settings extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
             
            $data   = Model::all()->toArray();
            $this->response->setStatus(true)->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
    public function getByCategory($id) {
        
         try{
                         
            $domain = \Helper\Input::get('domain','martireisen.at');
            $data   = Model::where(['visibility' => 1,'category' => $id, 'domain' => $domain])->get()->toArray();
            
            foreach($data as $index => $setting){
                
                $data[$index]['options'] = [];
                if($setting['type'] == '3'){
                    $data[$index]['options'] = $this->getSettingsOptions($setting);
                }
                if($setting['type'] == '4'){
                    $data[$index]['value']  = boolval($setting['value']);
                }
                
            }
            
            $this->response->setStatus(true)->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
    private function getSettingsOptions($setting){

        $options = [];
        switch($setting['key']){
            case 'sys_language':
                $options = Language::all('code','name')->toArray();
                break;
            
            case 'sys_currency':
                $options = Currency::all('code','name')->toArray();
                break;
            case 'sys_country':
                $options =Country::all()->toArray();
                break;
        }
        
        return $options;
    }
    
    public function store() {
        echo __METHOD__;
    }
    
    public function update($id = 0) {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            //'value' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }      
        var_dump($data);
        die();
        $this->save($data, $id);
        $this->response->setStatus(true)->out();
    }
    
    public function batchUpdate() {
        
        $data = \Helper\Input::json();
        if(!is_array($data)){
            $this->response->setStatus(false)->out();
        }
      
        foreach($data as $item){
            $this->save($item, $item->id);
        }
        
        $this->response->setStatus(true)->out();
    }
    
    public function save($data,$id) {
        
        $record = Model::find($id);
        if($record == NULL){
             return false;
        }
        
        if($record->value === $data->value){
            return false;
        }
        
        $log                    = new Log();
        $log->key               = $record->key;
        $log->old_value         = $record->value;
        $log->admin_id          = $this->session->id;
        $log->admin_fullname    = $this->session->firstname.' '. $this->session->lastname;
        $log->action            = 'SETTING.UPDATE';
        $log->text              = "Ayar değeri güncelleme işlemi";
        $log->ip                = $_SERVER['REMOTE_ADDR'];

        if($record->type == 4){
            $data->value = (int) $data->value;
        }
        
        $record->value        = $data->value == NULL ? '' : $data->value;        
        $record->save();
        
        $log->new_value = $record->value;
        $log->save();
        
        if($record->key == 'sys_language'){
            
            $language = Language::where('code',$record->value)->first();
            $language->is_default = 1;
            $language->save();
            
            Language::where('code', '!=' , $record->value)->update(['is_default' => 0]);
        }
        
        \Helper\Setting::set($record->key, $data->value, false,$record->domain);
        return true;
    }
    
    public function history($key) {
        
        if(empty($key)){
            $this->response->out();
        }
        
        $records = Log::where('key',$key)->skip(0)->take(10)->orderBy('id','DESC')->get()->toArray();
        $this->response->setStatus(true)->setData($records)->out();
        
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $setting  = Model::find($id);
        
        if($setting != NULL){
            
            $return = $setting->toArray();
            if($return['language'] == 1){
                $return['translate'] = $this->getLanguageContent($setting->id,$setting->value);
            }
            $this->response->setStatus(true)->setData($return)->out();
        }
        
        $this->response->out();
    }
    
    public function translate($settingId =0) {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'value'     => 'required',
            'language'  => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($settingId);
        
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if(strlen($data->language) != 2 ){
             $this->response->setMessage('Language Not Found')->out();
        }
        
        $settingTranslation = SettingTranslation::where(['setting_id' => $settingId,'language' => $data->language])->first();
        
        if($settingTranslation == NULL){
            $settingTranslation = new SettingTranslation();
            $settingTranslation->setting_id = $record->id;
            $settingTranslation->language = $data->language;
        }
        
        $settingTranslation->value     = isset($data->value) ? $data->value :  $settingTranslation->value;
        $settingTranslation->save();
        
        $this->response->setStatus(true)->out();
        
    }
    
         // LANGUAGE
    public function getLanguageContent($id ,$value) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'value' => '','default' => $language->code == $this->language ? 1 : 0);
            $translate  = SettingTranslation::where(['setting_id' => $id , 'language' => $language->code])->first();
            
            if($add['default'] == 1 ){
                $add['value'] = $value;
            }else if($translate!= NULL) {
                $add['value'] = $translate->value;
            }
            
            array_push($return,$add);
        }
        
        return $return;        
    }
    
    public function destroy($id = 0) {
        echo __METHOD__;
    }     
}
