<?php

namespace Application\Main;

use Model\Booking\Booking as BookingModel;
use Model\Booking\Travellers;
use Model\Booking\Transports;
use Core\Base\Application;
use Model\TourView;

class Booking  extends Application{

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->header();
        $this->footer();
    }
    
    public function complete($code = '') { 
        
        $booking  = \Core\Session\Session::get('last_booking');
        if(!empty($code)){
            $booking = base64_decode($code);
        }
        
        if($booking == NULL){
            \Core\Http\Redirect::go('/');
        }
          
        try {
            \Core\Session\Session::set('booking_data',null);
            
            $record = BookingModel::where('code',$booking)->first();
            $data   = $record->toArray();
            $travellers         = Travellers::where('booking_code',$data['code'])->get();
            $data['travellers'] = $travellers->toArray();
            $data['service']    = json_decode($data['api_service'],true);
            
            $flights            = Transports::where('booking_code',$data['code'])->get(); 
            $data['flights']    = $flights->toArray();
            
            if($data['source'] == 'Tour'){
                $tourView     =  new TourView();
                $data['tour'] = $tourView->get($data['hotel_giata_code']);
            }
            
            $data['api']          = [];
            $file = PATH.'/data/log/offer/'.$record->ref.'.txt';
            if(file_exists($file)){
                $obj = json_decode(file_get_contents($file),true);
                $data['offer'] = $obj['commonOffer'];
            }else{
                $data['offer'] = null;
            }

            $this->view->data = $data;

        }catch(\Exception $e){
            die('Invalid Request');
        }
        
        $this->header();
        $this->view->detail = !empty($code);
        $this->view->render('search/complete');
        $this->footer();
        
    }   
    
    
    public function failure() {
        
        \Core\Session\Session::set('payment_error',true);
       
        if(!empty(\Core\Session\Session::get('basket_url'))) {
            \Core\Http\Redirect::go(\Core\Session\Session::get('basket_url'));
        }else{
            \Core\Http\Redirect::go('/tour/booking');
        }

    }
    
    // gecici
    public function payComplete() {
        $this->header();
        $this->view->render('pay/complete');
        $this->footer();
    }
    
    public function payFailure() {
        $this->header();
        $this->view->render('pay/failure');
        $this->footer();
    }
}
