<?php

namespace Core\Base;

use Core\Base\Controller;
use Model\Link;
use Core\Cache\RedisCache;

class Application extends Controller{

    public $meta;
    public $cacheStatus = false;
    public $cacheModel;
    public $language;
    public $template;
    public $redisCache;
    public $domain;

    public function __construct($opts = array()) {
        
        $this->domain = \Helper\Config::getDomain();
        
        \Core\App::setType('web');
        parent::__construct();

        $this->maintanance();
        $this->cacheModel = new \Core\Cache\FileCache();
        
        if($opts['nocache'] == true || \Helper\Setting::get('file_cache') == false){
            $this->cacheModel->setActive(false);
        }
     //   $this->cacheModel->setActive(true);
        $this->cacheModel->pull();

        ob_start();

        $this->ssl();
        $this->www();
        $this->theme();
        $this->meta();
        $this->site();
        
        if(!isset($_SESSION['customer_currency'])){
            $_SESSION['customer_currency'] = 'EUR';
        }
        
        $this->language = \Model\User\Customer::getLanguage();
        $this->template = new \Core\Template\Template();
        
        $this->redisCache = RedisCache::getInstance();
        $this->redisCache->setLanguage($this->language);

    }

    public function theme() {

        $theme        = \Helper\Setting::get('theme');
        $activeTheme  = $theme == false ? 'default' : $theme;
        $this->view->setPath(PATH.'/themes/web/'.$activeTheme.'/');
    }

    public function maintanance() {

        $maintenance  = (int)\Helper\Setting::get('maintenance');
        if($maintenance === 1 && (int) \Model\User\Admin::get('id') == 0){
            echo \Helper\Setting::get('maintenance_content');
            die();
        }
    }

    public function ssl() {

        $ssl  = (int)\Helper\Setting::get('ssl');
        if($ssl === 1 && $_SERVER['HTTPS'] !== 'on'){

            $actual_link = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            \Core\Http\Redirect::go($actual_link);
        }
    }

    public function www() {

        $www  = (int)\Helper\Setting::get('www');
        if (strpos($_SERVER['HTTP_HOST'], 'www') === false && $www === 1) {
            $protocol = isset($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN) ? 'https' : 'http';
            header( "Location: $protocol://www." . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true,301 );
        }

    }

    public function meta() {

        $metaArr = array(
            'title'         => \Helper\Setting::get('title'),
            'keywords'      => \Helper\Setting::get('keywords'),
            'description'   => \Helper\Setting::get('description')
        );
        
        $route = empty(\Core\App::$route) ? 'index/index' : \Core\App::$route;
        
        $record = Link::select('id','locale','title','keywords','description')->where('route',  $route)->where('locale',\Core\App::$linkData['locale'])->first();
        
        if($record != NULL){
            $record = $record->toArray();
        }
        $alternates = [];
        $alternate  = Link::select('value','locale')->where('route', $route)->get();
        $default    = null;
        
        if($route == 'index/index'){
            array_push($alternates,['language' => 'de' , 'url' => '']);
        }
        $box = [];
        foreach($alternate as $a){
            
            if($a->locale == 'de'){
                $default = $a->value;
            }
            if(in_array($a->locale,$box)){
                continue;
            }
            array_push($box,$a->locale);
            $a->value = rtrim($a->value,'/');
            $alternates[] = ['language' => $a->locale , 'url' => $a->value.'/'] ;
        }
        
        if($default != null){
            $default  = rtrim($default,'/');
            array_push($alternates,['language' => 'x-default' , 'url' => $default.'/']);
        }
        
        if($route == 'index/index'){
            array_push($alternates,['language' => 'x-default' , 'url' => '']);
        }
        
        $url  = \Helper\Config::getDomain();
        
        
        if((int)$record['id'] > 0){
             $metaArr = array(
                'title'         => $url == 'akin.at' ? \Helper\Replace::to($record['title']) : $record['title'],
                'keywords'      => $url == 'akin.at' ? \Helper\Replace::to($record['keywords']) : $record['keywords'],
                'description'   => $url == 'akin.at' ? \Helper\Replace::to($record['description']) : $record['description'],
                'locale'        => $record['locale'],
                'alternates'    => $alternates
            );
        }else{
            $metaArr['alternates'] = $alternates;
        }
        $this->view->meta = $metaArr;

    }
    
    public function site() {

        $siteArr = array(
            'logo'          => \Helper\Setting::get('logo'),
            'phone'         => \Helper\Setting::get('phone'),
            'email'         => \Helper\Setting::get('email'),
            'address'       => \Helper\Setting::get('address')
        );

        $this->view->site  = $siteArr;

    }


    public  function header() {
       
        $languages = $this->redisCache->getArr('languages');
        
        if($languages == false){
            $languageModel = new \Model\Localization\Language();
            $languages     = $languageModel->where('is_active',1)->get()->toArray();
            $this->redisCache->setArr('languages',$languages);
        }
        
        $currencies = $this->redisCache->getArr('currencies');
        
        if($currencies == false){
            $currencyModel = new \Model\Localization\Currency();
            $currencies     = $currencyModel->where('is_active',1)->get()->toArray();
            $this->redisCache->setArr('currencies',$currencies);
        }
        
        $tree = $this->redisCache->getArr('menu_tree_1');
        $tree = false;
        if($tree == false){
            $categoryModel = new \Core\Structure\Category('menu__list_category');
            $categoryModel->menuId = 1;
            $categoryModel->setLanguage($this->language);
            $tree = $categoryModel->getTree(0,1);
         //   var_dump($tree);
            $this->redisCache->setArr('menu_tree_1',$tree);
        }        
        
        $this->view->languages  = $languages;
        $this->view->currencies = $currencies;
        $this->view->main_menu = $tree;
        $this->view->render('master/header');

    }
   
    public  function footer() {
        
        $url  = \Helper\Config::getDomain();

        $menuAll = $this->redisCache->getArr('menu_all'.$url);
        
        if($menuAll == false){
            $menuAll = array();
            $categoryView    = new \Model\Design\Menu\CategoryView();
            $menuList        = \Model\Design\Menu\Menu::all();
            foreach($menuList as $menu){
                $menuAll[$menu->code] =  $categoryView->get($menu->id);
            }
            $this->redisCache->setArr('menu_all',$menuAll);
        }
      
        $this->view->menu = $menuAll;
        $this->view->render('master/footer');

    }

    public function language() {

        $languageModel          = new \Model\Settings\Languages();
        $languageModel->is_active = 1;
        $this->view->languages  = $languageModel->get()->result();

    }
    
    public static function params($data,$step = 2) {
        
        $keys = ['children','adults','date','departure','destination','params','sf','vc','ref','gid','duration','flight','operators','seaview','transfer','attributes','travel_type'];
        
        if(!isset($data['children'])){
            $data['children'] = [];
        }
        
        if(!isset($data['adults']) || empty($data['adults'])){
            $data['adults']  = 2;
        }
        
        if(!isset($data['date']) || empty($data['date']['start'])){
            $data['date']['start']  = \Carbon\Carbon::now()->addDay(7)->format('Y-m-d');
        }
        
        if(!isset($data['date']) || empty($data['date']['end'])){
           
            $days = 30;
            if(is_numeric($data['duration']) && $data['duration'] > 0){
                $days = $data['duration'];
            }else if ($data['duration'] > 0 ){
                $explode = explode('-', $data['duration']);
                $days = $explode[1];
            }
          
            $data['date']['end']    = \Carbon\Carbon::parse($data['date']['start'])->addDay($days)->format('Y-m-d');
        }
        
        if(!isset($data['sf']) ){
            $data['sf'] = 2;
        }
        
        if(!isset($data['operators']) ){
            $data['operators'] = [];
        }
        
        if(!isset($data['vc']) ){
            $data['vc'] = $data['vc'];
        }
        
        if(!isset($data['destination'])){
            $data['destination'] = array(
                'type' => '',
                'name' => '',
                'code' => ''
            );
        }
        
        if(!isset($data['departure'])){
            $data['departure'] = array(
                'name' => '',
                'code' => ''
            );
        }
        
        if(!isset($data['duration']) ){
            $data['duration'] = 7;
        }
        
        if(!isset($data['seaview']) ){
            $data['seaview'] = 0;
        }    
        
        if(!isset($data['transfer']) ){
            $data['transfer'] = 0;
        }    
        
        // sadece tekliflerde calısacak bu filtre
        if($step == 3){
            if(!isset($data['flight']['departure']) ){
                $data['flight']['departure'] = ['00:00','23:59']; 
            }
            if(!isset($data['flight']['arrival']) ){
                $data['flight']['arrival'] = ['00:00','23:59'];
            }
        }
       
        
        foreach($data as $k => $d){
            if(!in_array($k, $keys)){
                unset($data[$k]);
            }
        }
        return $data;
    }

    public function __destruct() {

        if($this->cacheModel  === NULL){
            return;
        }
        $this->cacheModel->put();
    }
}
