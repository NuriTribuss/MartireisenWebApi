<?php

namespace Application\Api\Engine;

use Core\Base\Service;
use Helper\Header;
use Model\Crm\Subscriber as Model;;

class Subscribers extends Service {

    private $language;

    public function addSubscriber(){
        $this->language = Header::language();
        $email = \Helper\Input::json()->email;

        if($email == null || $email == ''){
            $this->response->setStatus(false)->setMessage("Not valid!")->out();
        }

        $current_email = Model::where('email',$email)->first();
        if($current_email != null){
            $this->response->setStatus(false)->setMessage("This email address is already exist!")->out();
        }
        $sub_email = new Model();
        $sub_email->language = $this->language;
        $sub_email->email = $email;
        $sub_email->gender = 0;
        $sub_email->name ='';
        $sub_email->surname = '';
        $sub_email->save();

        $this->response->setData($sub_email)->setStatus(true)->out();

    }
}