<?php

namespace Application\Main;

use Core\Base\Application;
use Model\Tour\Tour AS TourModel;
use Model\Tour\Category;
use Model\Tour\Type;
use Model\Tour\Age;
use Model\TourView;
use Model\Tour\Tab;
use Model\Link;
use Model\Tour\Period;

class Tour  extends Application{
    
    public function __construct() {
        
        date_default_timezone_set('Europe/Istanbul');
        
        parent::__construct();
        $this->view->page = 'tour';
    }
        
    public function getAll() {
        
        return array(
            'ages'        => Age::all()->toArray(),
            'categories'  => Category::all()->toArray(),
            'types'       => Type::all()->toArray(),
        );
    }
        
   
    public function index() {
        
        $this->view->main       = 1;
        $this->view->step       = 1;
        $this->view->data       = $this->getAll();
        $this->view->tabs       = $this->getTabs();
        $this->view->months     = $this->getMonths();
        
        $this->filter([]);
      
    }
    
    public function getTabs() {
        
        $tabs = Tab::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['active' => 1])->orderBy('sort_number','ASC')->get();

        
        foreach($tabs as &$tab){
            
            if($tab['type'] == 2){
                $tab['children'] = $this->getByCountry($tab['type_table_id']);
            }else if ($tab['type'] == 1){
                $tab['children'] = $this->getByCategory($tab['type_table_id']);
            }
           
        }
        
        return $tabs;
    }
    
    public function getByCategory($type) {

         $result = [];

         $tourView = new TourView();
         $childrens =  TourModel::where(['active' => 1])->where('type', 'like', '%' . $type . '%')->skip(0)->take(4)->get()->toArray();
         foreach($childrens as $key => $children){
             array_push($result,$tourView->get($children['id']));
         }
         return $result;
    }
    
    public function getByCountry($country) {
        
        $result = [];
        
        $tourView = new TourView();
        $childrens =  TourModel::where(['active' => 1,'country_id' => $country])->skip(0)->take(4)->get()->toArray();
        foreach($childrens as $key=> $children){
            array_push($result,$tourView->get($children['id']));
        }
        return $result;
       
    }
    
    public function getByMonth($month,$count = false) {
        
        $periods = Period::all()->toArray();
        $result  = [];
        
        foreach($periods as $period){
           // var_dump($period); 
            
            $tour = TourModel::where('id',$period['tour_id'])->first();
            if($tour->active == 0 ){
                continue;
            }
            $p_m = date('m',$period['start_date']);
            if($period['start_date'] > time() && $p_m == $month ){
                array_push($result,$period);
            }
        }
      
        if($count){
            return count($result);
        }
        
        $tours = array_values(array_column($result, 'tour_id'));
        $tours = array_unique($tours);
        $result = $tours;
        return $result;
        
    }
    
    public function getMonths() {
        
        $months = Link::where('type','tour_month')->where('locale', $this->language)->orderBy('table_id')->get()->toArray();
        foreach($months as &$month){
            $month['count'] = $this->getByMonth($month['table_id'],true);
            
        }
        return $months;
    }
    
    public function search() {
        
        $data = array(
            'destination' => strip_tags(\Helper\Input::get('destination')),
            'station' => strip_tags(\Helper\Input::get('station')),
            'start_date'  => strtotime(\Helper\Input::get('start_date')),
        );
        
        $opts = [];
        if(!empty($data['destination'])){
            $opts['destination'] = $data['destination'];
        }
        if(!empty($data['start_date'])){
            $opts['start_date'] = $data['start_date'];
        }
        if(!empty($data['station'])){
            $opts['station'] = $data['station'];
        }
        $this->view->step = 1;
        $this->filter($opts);   
    }
    
    public function category($code) {
        
        $this->view->step = 1;
        $opts['category'] = $code;
        $this->filter($opts);      
    }
    
    public function type($id) {
        
        $this->view->step = 1;
        $record    = Type::find($id);
        $translate = \Model\Tour\TypeTranslation::where(['language' => $this->language , 'type_id' => $id])->first();
        if($translate != null){
            $record->translate = $translate;
        }
        
        $this->view->typeId = $id;
        $this->view->title = $record->translate->name;
        $opts['type'] = $record->code;
        $this->filter($opts);      
    }
    
    public function month($month) {
        
        $this->view->step = 1;
     //   $record = Type::find($id);
        
        $this->view->title = _lang('month.tr.'.$month, true).' '. _lang('tour.month_title',true);
        $opts['month'] = $month;
        $this->filter($opts);      
    }
    
    
    public function detail($id) {
        
        $this->view->step = 2;
        try{
            $tour = new TourView();
            $data = $tour->get($id);
        
        }catch(\Exception $e){
            $data = [];
        }
        
        $this->view->data = $data;
        $this->header();
        $this->view->render('tour/detail');
        $this->toScriptDetail($data);
        $this->footer();
    }
    
    public function filter($opts) {
        
        $this->view->data  = $this->getAll();
        
        if((int)$opts['month'] > 0 ){
            $result = [];
            $tours =  $this->getByMonth($opts['month']);
            foreach($tours as $tour){
                array_push($result,['id' => $tour]);
            }
        }else { 
            $model = TourModel::where('active', '=', 1);

            if(isset($opts['category'])){
                $model = $model->where('category', 'like', '%'.$opts['category'].'%');
            }

            if(!empty($opts['destination'])){
                $model = $model->where('destination', 'like', '%'.$opts['destination'].'%');
            }

            if(isset($opts['type'])){
                $model = $model->where('type', 'like', '%'.$opts['type'].'%');
            }

            if(isset($opts['age_group'])){
                $model = $model->where('age_group', 'like', '%'.$opts['age_group'].'%');
            }
            
            $result =  $model->orderBy('sort_number','ASC')->get();
            $result =  $result->toArray();
        }
       
        $tourview = new TourView();
        foreach($result as $key =>  &$r){
           
            $r = $tourview->get($r['id']);
            if(!empty($opts['start_date'])){
               $flag = false;
               foreach($r['periods'] as $period){
                   if($period['start_date'] >= $opts['start_date']){
                       $flag = true;
                   }
               }
               
               if($flag == false){
                   unset($result[$key]);
               }
            }
            
            if(isset($opts['station'])){
               $sFlag = false;
               foreach($r['periods'] as $period){
                   foreach($period['stations'] as $station){
                      
                        if(strpos($station['station'],$opts['station']) !== false){
                            $sFlag = true;
                            break;
                        }
                   }
                 
               }
               
               if($sFlag == false){
                   unset($result[$key]);
               }
            }
            
        }
        
        $this->header();
      
        $this->view->tours = $result;
        $this->toScript($result);
        $this->view->render('tour/list');
        $this->footer();
    }
    
    public function toScript($result) {
        
        $return = []; 
        foreach($result as $r) {
            $return[] = [
                'name'  =>  $r['title'],
                'id'    =>  $r['id'].'-'.$r['period']['id'],
            ];
        } 
        $str = '<script>var TourList = '. json_encode($return).';</script>';
        echo $str;
    }
    
    public function toScriptDetail($result) {
        
        $return = [
            'title'         => $result['title'],
            'id'            => $result['id'].'-'.$result['period']['id'],
            'price'         => $result['price']
        ]; 
      
        $str = '<script>var TourDetail = '. json_encode($return).';</script>';
        echo $str;
    }
    
    public function booking() {
        
        \Core\Session\Session::set('bookingRef_tour','tour');
        
        if(\Core\Session\Session::get('payment_error') == true){
            $this->view->payment_error = true;
            \Core\Session\Session::set('payment_error',null);
        }
      
        $this->step = 4;
        $this->view->page = 'tour';
        $this->header();
        
        $this->view->render('tour/booking');
        $this->footer();
    }
    
    
}