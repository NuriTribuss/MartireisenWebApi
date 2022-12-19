<?php

namespace Core\Template;

use Model\Setting;

class Template {

    protected $template;
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Template();
        }

        return self::$instance;
    }

    public function __construct() {
        
        $loader         = new \Twig\Loader\FilesystemLoader(PATH . '/themes/web/martireisen/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        
        $this->init();
        
        $this->template->addGlobal('currency', \Model\User\Customer::getCurrency());
        $this->template->addGlobal('language', \Model\User\Customer::getLanguage());   
        $this->template->addGlobal('theme_dir', theme_dir(true));
    }
    
    public function loadStr($str,$params) {
        
        $loader = new \Twig\Loader\ArrayLoader([
            'index.html' =>  $str,
        ]);
        $twig = new \Twig\Environment($loader);
        $twig->addFilter($this->format());
        return  $twig->render('index.html',$params);

    }

    public function init() {
        
        $setting    = Setting::where(['visibility' => 1])->get();
        $settingArr = [];
        
        foreach($setting as $s){
            $settingArr[$s->key] = $s->value;
        }
        
        $this->template->addFilter($this->translate());
        $this->template->addFilter($this->format());
        $this->template->addFilter($this->currencySymbol());
      
        $this->template->addGlobal('setting', $settingArr);

    }

    public function fetch($file = 'index.html', $data) {
        
        try{
            $template = $this->template->load($file);
            echo $template->render($data);
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function getGlobals() {
        return $this->template->getGlobals();
    }
    
    public function setting() {
        
        return new \Twig\TwigFilter('setting', function ($key) {
            return \Helper\Setting::get($key);
        });

    }
    
    public function translate() {
        
        return new \Twig\TwigFilter('translate', function ($key) {
            return \Core\Translation\Language::get($key);
        });

    }
    
    public function currencySymbol() {
        
        return new \Twig\TwigFilter('currencySymbol', function ($key) {
            
            $arr = [
                'EUR' => '€',
                'TRY' => '₺',
                'USD' => '$',
            ];
            return $arr[$key];
        });

    }   
    
    public function format() {
        
        return new \Twig\TwigFilter('format', function ($amount) {
            return @number_format($amount, '2', ',', '.');
        });

    }
}
