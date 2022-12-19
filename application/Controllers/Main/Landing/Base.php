<?php

namespace Application\Main\Landing;

use Core\Base\Application;

use Model\Region\Country;
use Model\Region\State;
use Model\Region\City;
use Model\Region\HotelFilter;
use Model\Localization\Translate;
use Model\Landing\Zone;
use Model\Landing\Base as BaseModel;
use Model\Landing\Footer;

class Base  extends Application {
    
    protected $api;
    protected $linkData;
    protected $type;
    public $filter = null;
    public $lastMinute = false;
    private $translate;
    
    public function __construct() {
        
        parent::__construct();
        
      //  $this->api = new \Model\Api\Client\Api();
      //  $this->api->setLanguage();
        
        $this->linkData =  \Core\App::$linkData;
        
        
        $this->view->hotelFilter    = HotelFilter::where(['active' => 1 ])->get()->toArray();
        $this->view->link           = \Core\App::$linkData;
        $this->translate            = new Translate();
    }
    
    public function index($f = '') {
        
        $countries = Country::where('is_active',1)->orderBy('sort_number','ASC')->get(); 
        
        if($countries != null){
            $countries = $countries->toArray();
            foreach ($countries as $i => $s){
                $countries[$i]['name'] = $this->translate->get($s['code'], 'CountryTitle', $this->language, $countries[$i]['name']);
            }
            $this->view->countries = $countries;
        }
        
        $data = BaseModel::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['code' => $this->linkData['route']])->first();
        
        if($data!= null){
            
            $data = $this->replaceDomain($data->toArray());
            $this->view->landing = $data;
        }
        
        $this->header();
        $this->faqGenerate();
        $this->view->landingFooter  = $this->getFooterLinks();

        $this->view->render('landing/index');
        $this->footer();
    }
    
    public function ferne($f = '') {
        
        $countries  = Country::where(['is_active' => 1 , 'is_ferne' => 1])->orderBy('sort_number','ASC')->get(); 
        $states     = State::where(['is_active' => 1 , 'is_ferne' => 1])->get(); 
        
        $countriesArr =  $countries->toArray();
        $stateArr = $states->toArray();
        
        $this->view->ferne = 1;
        $this->view->countries = array_merge($countriesArr,$stateArr);
        
        $data = BaseModel::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['code' => $this->linkData['route']])->first();

        if($data!= null){
            $this->view->landing = $data;
        }
        
        $this->header();
        $this->faqGenerate();
        $this->view->landingFooter  = $this->getFooterLinks();

        $this->view->render('landing/index');
        $this->footer();
    }
    
    public function topurlaub($f = '') {
        
        $countries    = Country::where(['is_active' => 1 , 'is_top' => 1])->orderBy('sort_number','ASC')->get(); 
        $countriesArr = $countries->toArray();
        
        $this->view->ferne = 1;
        
        $this->view->prefix = 'top urlaub';
        $this->view->countries = ($countriesArr);
        
        $data = BaseModel::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['code' => $this->linkData['route']])->first();

        if($data!= null){
            $this->view->landing = $data;
        }
        
        $this->header();
        $this->faqGenerate();
        $this->view->landingFooter  = $this->getFooterLinks();

        $this->view->render('landing/index');
        $this->footer();
    }
    
    public function billigurlaub($f = '') {
        
        $countries = Country::where('is_active',1)->orderBy('sort_number','ASC')->get(); 
        $countriesArr = $countries->toArray();
        
        $this->view->prefix = 'billig urlaub';
        $this->view->countries = ($countriesArr);
        
        $data = BaseModel::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['code' => $this->linkData['route']])->first();

        if($data!= null){
            $this->view->landing = $data;
        }
        
        $this->header();
        $this->faqGenerate();
        $this->view->landingFooter  = $this->getFooterLinks();

        $this->view->render('landing/index');
        $this->footer();
    }
    
    public function country($id) {
        
        $country = Country::find($id);
        
        if($country != null){
            
            $this->view->zone = $country->toArray();
            $this->view->zone['name'] = $this->translate->get($country->code, 'CountryTitle', $this->view->link['locale'], $this->view->zone['name']);
            $states = State::where('country_code',$country->code)->get();
            if($states != null){
                $states = $states->toArray();
                foreach ($states as $i => $s){
                    $states[$i]['name'] = $this->translate->get($s['code'], 'StateTitle', $this->language, $states[$i]['name']);
                }
                $this->view->states = $states;
            }
        }
        
        $data = Zone::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['code' =>$id,'type' => 'country', 'route' => $this->linkData['route']])->first();
        
        if($data!= null){
            $this->view->landing = $data->toArray();
            $this->replaceLanding($this->view->zone);

        }
        
        $this->replace($this->view->zone);
        $this->header();
        $this->faqGenerate();
        $this->view->landingFooter  = $this->getFooterLinks();
        $this->view->zoneFooter     = $this->view->zone;
        $this->view->zoneFooter['seo_url']  = !empty($country->{'seo_url_'.$this->language}) ?  $country->{'seo_url_'.$this->language} : $country->seo_url;
        
        $this->setDestination('region', $this->view->zone);
        $this->view->render('landing/country');
        $this->footer();

    }
    
    public function state($id) {
        
        $state = State::find($id);
        if($state != null){
            
            $this->view->zone = $state->toArray();
            $this->view->zone['name'] = $this->translate->get($state->code, 'StateTitle', $this->view->link['locale'], $this->view->zone['name']);
            
            $country = Country::where('code',$state->country_code)->first();
            $this->view->country = $country->toArray();
            
            $cities = City::where(['is_active' => 1, 'state_code' => $state->code])->get();
            if($cities != null){
                $this->view->cities = $cities->toArray();
            }
        }
        
        $data = Zone::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['code' =>$id,'type' => 'state', 'route' => $this->linkData['route']])->first();
        
        if($data!= null){
            $this->view->landing = $data->toArray();
            $this->replaceLanding($this->view->zone);

        }
        
        $this->replace($this->view->zone);
        $this->view->landingFooter  = $this->getFooterLinks();
        
        if($country->code == 'TR'){
            $this->view->zoneFooter  = $this->view->zone;
        }else{
            $this->view->zoneFooter  = $this->view->country;
            $this->view->zoneFooter['name'] = $this->translate->get($country->code, 'CountryTitle', $this->view->link['locale'], $this->view->zoneFooter['name']);
            $this->view->zoneFooter['seo_url']  = !empty($country->{'seo_url_'.$this->language}) ?  $country->{'seo_url_'.$this->language} : $country->seo_url;
        }
        
        $this->header();
        $this->setDestination('region', $this->view->zone);

        $this->faqGenerate();
        $this->view->render('landing/state');
        $this->footer();
    }
    
    public function city($id) {
        
        $city = City::find($id);
        if($city != null){
            
            $state  = State::where('code',$city->state_code)->first();
            $this->view->state = $state->toArray();
            $country = Country::where('code',$state->country_code)->first();
            $this->view->country = $country->toArray();

            $this->view->zone = $city->toArray();
        }      
        
        $data = Zone::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['code' =>$id,'type' => 'city', 'route' => $this->linkData['route']])->first();

        if($data!= null){
            $this->view->landing = $data->toArray();
            $this->replaceLanding($this->view->zone);
        }
        
        $this->replace($this->view->zone);
        $this->view->landingFooter  = $this->getFooterLinks();
        $this->view->zoneFooter     = $country->code != 'TR' ? $this->view->country : $this->view->zone;

        $this->header();
        $this->setDestination('city', $this->view->zone);

        $this->faqGenerate();

        $this->view->render('landing/city');
        $this->footer();
    }
    
    public function setDestination($type,$data) {
        
        $arr = [
            'type' => $type,
            'code' => $data['traffics_code'],
            'name' => $data['name']
        ];
        
        if($this->lastMinute) {
            $this->filter['productSubType'] = 'lastminute';
        }
        
        echo '<script>var zoneData = \''. json_encode($arr).'\'; </script>';
        echo '<script>var filterData = \''. json_encode($this->filter).'\'; </script>';
       /* $filterArr['destination'] = [
            'type' => $type,
            'code' => $data['code'],
            'name' => $data['name']
        ];
        
        if($type == 'city'){
            $filterArr['destination']['lat'] = $data['lat'];
            $filterArr['destination']['lng'] = $data['lng'];
        }*/
        
        return;
    }
    
    public function filterSession($filter) {
            
        $filterArr['sf'] = '3';

        switch($filter) {
            case 'eigene-anreise':
            case 'hotel':
                $filterArr['sf'] = '3';
                break;
            
            case 'familienhotels' :
                $filterArr['keywordList'] = ['chf','fcp','eec','ecc'];
                break;
            
            case 'erwachsenenhotels':
                $filterArr['keywordList'] = ['ado'];
                break;
            
            case 'sports-aktivurlaub':
                $filterArr['keywordList'] = ['spt'];
                break;
            
            case 'urlaub-mit-hund':
                $filterArr['keywordList'] = ['wel'];
                break;
            
            case 'wellnesshotels':
            case 'wellness':
                $filterArr['keywordList'] = ['wel'];
                break;
            
            case 'strandhotels':
                $filterArr['keywordList'] = ['bea'];
                break;
            
            
            case 'kurzurlaub':
              $filterArr['duration'] = 3;
              break;
        }
        
        $this->filter = $filterArr;
    }
    
    public function replace($zone) {
        
        $data =  \Core\App::$linkData;
        $meta =  $this->view->meta;
                
        $data['title']       = str_replace('{#region_name#}',$zone['name'],$data['title']);
        $data['description'] = str_replace('{#region_name#}',$zone['name'],$data['description']);
        $data['keywords']    = str_replace('{#region_name#}',$zone['name'],$data['keywords']);
        $data['alternates']  = $meta['alternates'];
        
        $url  = \Helper\Config::getDomain();
        
        if($url == 'akin.at'){
            $data['title']       = \Helper\Replace::to($data['title']);
            $data['description'] = \Helper\Replace::to($data['description']);
            $data['keywords']    = \Helper\Replace::to($data['keywords']);
        }
          
        $this->view->meta = $data;
        $this->view->link = $data;
    }
    
    public function replaceLanding($zone) {
        
        $data = $this->view->landing;
        
        $data['translate']['title']              = str_replace('{#region_name#}',$zone['name'],$data['translate']['title']);
        $data['translate']['subtitle']           = str_replace('{#region_name#}',$zone['name'],$data['translate']['subtitle']);
        $data['translate']['second_title']       = str_replace('{#region_name#}',$zone['name'],$data['translate']['second_title']);
        $data['translate']['third_title']        = str_replace('{#region_name#}',$zone['name'],$data['translate']['third_title']);
        
        $data = $this->replaceDomain($data);
          
        $this->view->landing = $data;
        
        return $data;
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
    
    public function getFooterLinks() {
        
        $links = Footer::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->get();
        
        $links = $links->toArray();
        foreach($links as $key=> $l){
            $links[$key]['translate']['url'] = $links[$key]['translate']['url'].'/';
        }
        
       // $links = \Model\Landing\FooterLink::where('language', \Model\User\Customer::getLanguage())->get()->toArray();
        return $links;
    }
    
    public function faqGenerate() {
        
        $linkData = $this->view->link;
        $faq = \Model\Link\LinkFaq::where('link_id',$linkData['id'])->get()->toArray();
        
        $schema = [
            "@context" =>  "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => []
        ];
        
        if(count($faq) == 0){
            return false;
        }
        
        foreach($faq as $f){
            $schema['mainEntity'][] = [
                "@type" =>  "Question",
                "name"  =>  $f['question'],
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text"  => $f['answer']
                ]
            ];
        }
        
        echo '<script type="application/ld+json">';
        echo json_encode($schema);
        echo '</script>';
        
       
    }
}