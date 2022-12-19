<?php

namespace Model\Mail;

class Message{

    protected $connection;
    protected $mailer;
    protected $message;
    protected $lang;
    protected $langVars = [];

    public function __construct() {

        $this->connection = (new \Swift_SmtpTransport(\Helper\Config::get('MAIL_HOST'), 587))
            ->setUsername(\Helper\Config::get('MAIL_USER'))
            ->setPassword(\Helper\Config::get('MAIL_PASSWORD'));

        $this->mailer  = new \Swift_Mailer($this->connection);
        $this->message = new \Swift_Message();
        $this->message->setFrom([\Helper\Config::get('MAIL_SENDER') =>\Helper\Config::get('MAIL_SENDER_NAME') ]);
        $this->lang    = new \Core\Translation\Language();
    }


    public function send($message) {

        $this->message->setSubject($message['subject']);
        $this->message->setTo(is_array($message['mail']) ? $message['mail'] : [$message['mail']]);
        $this->message->setBody($message['body'],'text/html');

        try{
            return $this->mailer->send($this->message);
        }catch(\TransportException $e){

        }catch(\SwiftException $e){

        }

    }

    public function addLangVars($param) {       
        $this->langVars =  array_merge($this->langVars,$param);
        return $this->langVars;
    }

    public function getLangVars() {
        return $this->langVars;
    }
}
