<?php

namespace Model\Notification;

use Model\Notification\Mail;
use Model\Notification\Sms;
use Model\Notification\Template;
use Model\View;

class NotificationView extends View {

    public $data;
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function getByCode($code,$type = 'mail') {
        
        $template = Template::where(['code' => $code])->first();
        if($template == null){
            return false;
        }
        
        $data = [];
        
        switch($type){
            case 'mail':
                $data =  Mail::where(['template_id' => $template->id , 'language' => $this->language])->first();
                break;
            
            case 'sms':
                $data =  Sms::where(['template_id' => $template->id , 'language' => $this->language])->first();
                break;
        }
        
        return $data;
        
    }
    
    public function params($code = null) {
        
        $orderView = new \Model\Ecommerce\Order\OrderView();
        $data = $orderView->get();
        
        return array_keys($data);
    }
    
}
