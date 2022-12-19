<?php

namespace Application\Main;

use Core\Base\Application;
use Model\Customer\Customer as Customer;
use Model\User\Customer as CustomerSession;
use Model\Content\Page;
use Model\Booking\Booking;

class My  extends Application{

    public function __construct() {
        parent::__construct();
    }
    
    public function checklogged() {
        
        if(!\Model\User\Customer::isLogged()){
            \Core\Http\Redirect::go('/');
        }
        
        $id         = CustomerSession::getId();
        $account    = Customer::where('id',$id)->first(['gender','name','surname','address','country','city','town','phone','username']);
        
        $this->view->account = $account->toArray();
        
    }
    
    public function index() {
                
        $this->checklogged();
        
      //  $pages = Page::where(['is_profile' => 1,'locale' => CustomerSession::getLanguage()])->get()->toArray();
        $this->view->pages = $pages;
        $this->header();
        $this->view->render('my/index');
        $this->footer();
    }
    
    public function reservations() {
                
        $this->checklogged();
        
        $bookings = Booking::where(['customer_id' =>  CustomerSession::getId()])->orderBy('id','DESC')->limit(10)->get()->toArray();
        $this->view->bookings = $bookings;
        $this->header();
        $this->view->render('my/booking');
        $this->footer();
    }
    
    public function profile() {
        
        $this->checklogged();
        $this->header();
        $this->view->render('my/profile');
        $this->footer();
    }
    
    public function password() {
        
        $this->checklogged();
        $this->header();
        $this->view->render('my/password');
        $this->footer();
    }

    public function recoveryPassword($token) {

        if(\Model\User\Customer::isLogged()){
            \Core\Http\Redirect::go('/');
        }
        
        $this->view->token = $token;
        $this->header();
        $this->view->render('my/reset-password');
        $this->footer();
              
    }


}
