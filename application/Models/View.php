<?php

namespace Model;

class View {
    
    protected $language;
    protected $defaultLanguage;

    function __construct() {
        $this->language        = User\Customer::getLanguage();
        $this->defaultLanguage = \Helper\Setting::get('language');
    }

}

