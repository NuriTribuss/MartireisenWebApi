<?php

namespace Application\Api\Notification;

use Core\Base\Webservice;
use Model\Notification\Template as Model; 
use Model\Notification\Group;

class Template extends Webservice {


    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
           
            $data   = [];
            $groups = Group::all();
            
            foreach($groups as $index => $group){
                $data[$index] = $group->toArray();
                $data[$index]['templates'] = Model::where('group_code',$group->code)->get()->toArray();
            }
            
            $this->response->setStatus(true)->setMeta([])->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
    public function mail($templateId) {
        
        $mail = new Mail(); 
        $mail->templateId = $templateId; 
        $mail->index(); 
    }
    
    public function sms($templateId) {
        
        $sms = new Sms(); 
        $sms->templateId = $templateId; 
        $sms->index(); 
    }
    
    public function store() {
        echo __METHOD__;
    }
    
    
    public function update($id = 0) {
        echo __METHOD__;
    }
    
    public function show($id = 0) {
        echo __METHOD__;
    }
    
    public function destroy($id = 0) {
        echo __METHOD__;
    }     

}
