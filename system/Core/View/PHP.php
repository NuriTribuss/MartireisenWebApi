<?php

namespace Core\View;
use Core\View\View;

class PHP extends View {

    public $template;
    private static $instance;

    public function render($name) {

        $file = $this->getPath(). $name .'.php';
        if(file_exists($file)) {
            require $file;
        }else {
            $error = new \Helper\Error;
            $error->type('warning')->message('Theme File Not Found')->show();
        }
    }

    public function breadcrumb() {

        $file = $this->getPath(). 'master/breadcrumb' .'.php';
          echo $file;
        if(file_exists($file)) {
            require $file;
        }else {
            $error = new \Helper\Error;
            $error->type('warning')->message('View File not found')->show();
        }
    }

    public function renderMail($name) {

        $file = PATH.'/themes/mail/'. $name .'.php';
        if(file_exists($file)) {
            require $file;
        }else {
            $error = new \Helper\Error;
            $error->type('warning')->message('View File not found')->show();
        }
    }

    public static function getInstance(){
        if (null === static::$instance) {
            static::$instance = new PHP();
        }

        return static::$instance;
    }

}
