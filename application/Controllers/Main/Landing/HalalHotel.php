<?php

namespace Application\Main\Landing;

use Model\Region\Defaults\Country;
use Core\Base\Application;
use Model\Landing\Base;

class HalalHotel  extends Application{
  
    public function index() { 
        
        $this->view->page = 'halalbooking';

        $data = Base::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['code' => \Core\App::$linkData['route']])->first();
        
        $countries = Country::where('is_active',1)->orderBy('sort_number','ASC')->get(); 
        $countries = $countries->toArray();
                
        foreach($countries as $index => $country){
            $countries[$index]['name'] = isset($country['name_'.$this->language]) ? $country['name_'.$this->language] : $country['name'];
            $countries[$index]['url']  = $this->prefix().\Helper\Url::beautify($countries[$index]['name']);
        }
        
        $data = $this->replaceDomain($data->toArray());
        
        $assign = [
            'countries' => $countries,
            'data'      => $data
        ];
        
       
        
        $this->header();
        $this->template->fetch('landing/halal-index.tpl',$assign);
        $this->footer();
        
    }
    
    public function prefix() {
        return $this->language == 'de' ? '/halal-hotels/' : '/tr/islami-otel/';
    }
    
    public function replaceDomain($data) {
        
        $url  = \Helper\Config::getDomain();
        if($url == 'akin.at'){
            $data['translate']['title']              = \Helper\Replace::to($data['translate']['title']);
            $data['translate']['subtitle']           = \Helper\Replace::to($data['translate']['subtitle']);
            $data['translate']['second_title']       = \Helper\Replace::to($data['translate']['second_title']);
            $data['translate']['second_subtitle']    = \Helper\Replace::to($data['translate']['second_subtitle']);
            $data['translate']['third_title']        = \Helper\Replace::to($data['translate']['third_title']);   
            $data['translate']['content']            = \Helper\Replace::to($data['translate']['content']);           
        }
        
        return $data;
    }
}