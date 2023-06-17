<?php

namespace Model\Mail;

use Model\Mail\Message;
use Model\Mail\Template;

class Customer extends Message{

    public $template;
    public  $dataMode = false;

    public function __construct() {

        parent::__construct();
        $this->template = new Template();
        $this->addLangVars($this->lang->load(['MAIL_COMMON','MAIL_CUSTOMER'],'mail'));
    }

    public function sendRegistrationMail($mail ,$params) {

        $section = $this->lang->load(['MAIL_CUSTOMER_REGISTER'],'mail');
        $this->addLangVars($section);

        $this->template->assignLang($this->getLangVars());
        $this->template->assign($params);

        $message = array(
            'subject' => $section['mail_subject'],
            'mail'    => $mail,
            'body'    => $this->template->run('signin-customer')
        );
        
        if($this->dataMode){
            return $message;
        }

        return $this->send($message);
    }

    public function sendResetPassword($mail ,$params) {

        $section = $this->lang->load(['MAIL_CUSTOMER_RESET_PASSWORD'],'mail');
        $this->addLangVars($section);

        $this->template->assignLang($this->getLangVars());
        $this->template->assign($params);

        
        $message = array(
            'subject' => $section['mail_subject'],
            'mail'    => $mail,
            'body'    => $this->template->run('reset-password-customer')
        //    'body'    => $this->template->fetch('customer/reset-password-customer')
        );
        
        if($this->dataMode){
            return $message;
        }
        
        return $this->send($message);
    }

    public function sendPasswordChanged($mail ,$params) {

        $section = $this->lang->load(['MAIL_CUSTOMER_PASSWORD'],'mail');
        $this->addLangVars($section);

        $this->template->assignLang($this->getLangVars());
        $this->template->assign($params);

        $message = array(
            'subject' => $section['mail_subject'],
            'mail'    => $mail,
            'body'    => $this->template->run('change-password-customer')
        );
        
        if($this->dataMode){
            return $message;
        }
        
        return $this->send($message);

    }

    public function sendBookingRequested($mail ,$booking) {
        
        $section = $this->lang->load(['MAIL_CUSTOMER_BOOKING'],'mail');
        $section2 = $this->lang->load(['GENERAL'],'web');
        
        $this->addLangVars($section);
        $this->addLangVars($section2);
        
        $languages = $this->getLangVars();
       // var_dump($languages);
                
        $bookingView = new \Model\BookingDetailView();
        $params      = $bookingView->get($booking);
        $params['language'] = $languages;
        $params = array_merge($params, $this->getCommonParams());
        
        
        $template    = new \Core\Template\Template();
        $arg         = \Helper\Setting::get('booking-requested');
        if($booking['source'] == 'Tour'){
            $arg  = \Helper\Setting::get('booking-requested-tour');
        }
        $content     = $template->loadStr($arg, $params );
        

        $message = array(
            'subject' => $section['mail_subject_request'].' #'.$params['code'],
            'mail'    => $mail,
            'body'    => $content
        );
       
        if($this->dataMode){
            return $message;
        }
        $send = $this->send($message);
        
        if($booking['source'] == 'Tour'){
           $message['mail'] = ['kb@martireisen.at','osman@martireisen.at','mercelnet@gmail.com'];
        }else{
           $message['mail'] = ['web@tribus-business.at','mercelnet@gmail.com'];
        }
        
        $this->send($message);
        
        return $send;
    }


    public function sendBookingSuccessfulPayment($booking) {

        $section = $this->lang->load(['MAIL_CUSTOMER_BOOKING'],'mail');
        $section2 = $this->lang->load(['GENERAL'],'web');

        $this->addLangVars($section);
        $this->addLangVars($section2);

        $languages = $this->getLangVars();
        // var_dump($languages);

        $bookingView = new \Model\BookingDetailView();
        $params      = $bookingView->get($booking);
        $params['language'] = $languages;
        $params = array_merge($params, $this->getCommonParams());


        $template    = new \Core\Template\Template();
        $arg         = \Helper\Setting::get('booking-requested');
        if($booking['source'] == 'Tour'){
            $arg  = \Helper\Setting::get('booking-requested-tour');
        }
        $content     = $template->loadStr($arg, $params );


        $message = array(
            'subject' => 'Successful Payment #'.$params['code'],
            'mail'    => '',
            'body'    => $content
        );

        if($booking['source'] == 'Tour'){
            $message['mail'] = ['kb@martireisen.at','osman@martireisen.at','mercelnet@gmail.com'];
        }else{
            $message['mail'] = ['web@tribus-business.at','mercelnet@gmail.com'];
        }

        $send = $this->send($message);

        return $send;
    }
    
    public function sendBookingRequestedTest($booking) {
        
        $section = $this->lang->load(['MAIL_CUSTOMER_BOOKING'],'mail');
        $section2 = $this->lang->load(['GENERAL'],'web');
        
        $this->addLangVars($section);
        $this->addLangVars($section2);
        
        $languages = $this->getLangVars();
       // var_dump($languages);
                
        $bookingView = new \Model\BookingDetailView();
        $params      = $bookingView->get($booking);
        $params['language'] = $languages;
        $params = array_merge($params, $this->getCommonParams());
        
        
        $template    = new \Core\Template\Template();
        $arg         = \Helper\Setting::get('booking-requested');
        if($booking['source'] == 'Tour'){
            $arg  = \Helper\Setting::get('booking-requested-tour');
        }
        
    
        $arg = file_get_contents(PATH.'/themes/web/martireisen/email.tpl'); 
        
       
        $content     = $template->loadStr($arg, $params );
        $mail = 'mercelnet@gmail.com';
        $message = array(
            'subject' => $section['mail_subject_request'].' #'.$params['code'],
            'mail'    => !empty($_GET['mail']) ? $_GET['mail'] : $mail,
            'body'    => $content
        );
       
        if($this->dataMode){
            return $message;
        }
        
        echo $content;
        $send = $this->send($message);
        return $send;
    }

    public function sendBookingApproved($mail ,$params) {
        
        $section = $this->lang->load(['MAIL_CUSTOMER_BOOKING'],'mail');
        $this->addLangVars($section);

        $this->template->assignLang($this->getLangVars());
        $this->template->assign($params);

        $message = array(
            'subject' => $section['mail_subject_approved'],
            'mail'    => $mail,
            'body'    => $this->template->fetch('customer/booking-approved')
        );
        
        if($this->dataMode){
            return $message;
        }

        return $this->send($message);
    }

    
    public function getCommonParams() {
        
        $url = \Helper\Config::get('SITE_URL');
        
        return  array(
            'url'       => $url,
            'logo'      => $url.'/'.\Helper\Setting::get('logo'),
            'email_logo' => $url.'/'.\Helper\Setting::get('email_logo'),
            'slogan'    => 'Traumreise mit Bestpreis Garantie!',
            'address'   => \Helper\Setting::get('address'),
            'phone'     => \Helper\Setting::get('phone'),
            'copyright'     => \Helper\Setting::get('copyright'),
            'facebook'  => \Helper\Setting::get('facebook'),
            'twitter'   => \Helper\Setting::get('twitter'),
            'instagram' => \Helper\Setting::get('instagram'),
            'youtube'  =>  \Helper\Setting::get('youtube'),
            'generator' => 'Marti Reisen',
        );
        
    }
}