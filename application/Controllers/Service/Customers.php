<?php

namespace Application\Service;

use Core\Base\Service;
use Model\Customer\Customer as Customer;
use Model\User\Customer as CustomerSession;

class Customers extends Service {

    public function __construct() {

        parent::__construct();
    }

    public function login() {

        $user = \Helper\Input::post('username');
        $pass = \Helper\Input::post('password');

        if (empty($user) || empty($pass)) {
            $this->response->setMessage(_lang('user.required_field', true))->out();
        }

        $find = Customer::where('username', $user)->where('password', md5($pass))->first(['username', 'name', 'surname', 'id']);
        if ($find == NULL) {
            $this->response->setMessage(_lang('user.login_error', true))->out();
        }

        $this->setCustomerSession($find);
        $this->response->setStatus(true)->setData($find)->out();
    }

    public function save($id = NULL) {

        $data = \Helper\Input::all(true);

        if (\Model\User\Customer::isLogged()) {
            $id = CustomerSession::getId();
        }

        try {

            $customer = $id != NULL ? Customer::findOrFail($id) : new Customer();

            $check = Customer::checkFields($data);
            if ($check !== true) {
                $this->response->setData(array('field' => $check, 'type' => 'empty'))->setMessage(_lang('user.required_field', true))->out();
            }

            if ($id == NULL) {
                $exists = Customer::where('username', $data['username'])->first();
                if ($exists->username !== NULL) {
                    $this->response->setData(array('type' => 'exists'))->setMessage(_lang('user.username_exist', true))->out();
                }
            }

            foreach ($data as $key => $val) {
                if (is_null($val)) {
                    continue;
                }
                $customer->$key = $val;
            }
            $customer->password = md5($customer->password);
            $customer->language = \Core\Translation\Language::getLanguage();
            $customer->save();

            if ($id == NULL) {

                $mail = new \Model\Mail\Customer();
                $mail->sendRegistrationMail($data['username'], $data);
            }
            
            $message = _lang('user.reset_info_successfull', true);
            if($customer->newsletter == 1){
                $message =  _lang('user.subscriber_successfull', true);
            }else{
                $this->setCustomerSession($customer);
            }
            
            $this->response->setStatus(true)->setMessage($message)->out();
        } catch (\Exception $e) {
            $this->response->setMessage($e->getMessage())->http(404);
        }
        $this->response->out();
    }

    public function recoveryPassword() {

        $data = array(
            'username' => \Helper\Input::post('username', '')
        );

        $account = Customer::where('username', $data['username'])->first();

        if ($account != NULL) {

            $account->recovery_key = \Helper\Input::generateRandomString(20);
            $account->save();

            $data = $account->toArray();
            $data['recovery_url'] = '<a href="https://martireisen.at/my/recovery-password/' . $account->recovery_key . '"  class="es-button" style="mso-style-priority: 100 !important; text-decoration: none; -webkit-text-size-adjust: none; -ms-text-size-adjust: none; mso-line-height-rule: exactly; font-family: arial, \'helvetica neue\', helvetica, sans-serif; font-size: 18px; color: #ffffff; border-style: solid; border-color: #F7A83A; border-width: 10px 20px 10px 20px; display: inline-block; background: #F7A83A; border-radius: 30px; font-weight: normal; font-style: normal; line-height: 22px; width: auto; text-align: center;" target="_blank" rel="noopener">Reset Password</a>';

            $mail = new \Model\Mail\Customer();
            $mail->sendResetPassword($account->username, $data);
            $this->response->setStatus(true)->setMessage(_lang('user.mail_found_error', true))->out();
        } else {
            $this->response->setStatus(false)->setMessage(_lang('user.mail_found_error', true))->out();
        }
    }

    public function resetPassword() {

        $data = array(
            'password' => \Helper\Input::post('password', ''),
            'recovery_key' => \Helper\Input::post('recovery_key', '')
        );

        if (empty($data['recovery_key']) || empty($data['password']) || strlen($data['password']) < 4) {
            $this->response->setMessage(_lang('user.password_error', true))->out();
        }

        $account = Customer::where('recovery_key', $data['recovery_key'])->first();

        if ($account != NULL) {
            $account->password = md5($data['password']);
            $account->recovery_key = '';
            $account->save();
            $this->response->setStatus(true)->setMessage(_lang('user.reset_password_successfull', true))->out();
        } else {
            $this->response->setMessage(_lang('user.recovery_key_error', true))->out();
        }
    }

    public function subscribe() {

        $check   = true; // \Helper\Security::captcha();
        $email   = \Helper\Input::post('email', '');
        $name    = \Helper\Input::post('name', '');
        $surname = \Helper\Input::post('surname', '');
        $gender  = \Helper\Input::post('gender', 0);

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response->setStatus(false)->setMessage(_lang('user.subscribe_email', true))->out();
        }
        
        if ($check == false) {
            $this->response->setStatus(false)->setMessage(_lang('user.security_code_invalid', true))->out();
        }

        $exists = \Model\Crm\Subscriber::where('email', $email)->first();
        if ($exists != NULL) {
            $this->response->setStatus(false)->setMessage(_lang('user.subscriber_exists', true))->out();
        } else {

            $subscriber = new \Model\Crm\Subscriber();
            $subscriber->email      = $email;
            $subscriber->name       = $name;
            $subscriber->surname    = $surname;
            $subscriber->gender     = $gender;
            $subscriber->language   = \Core\Translation\Language::getLanguage();
            $subscriber->save();
            
            $this->response->setStatus(true)->setMessage(_lang('user.subscriber_successfull', true))->out();
        }
    }

    public function logout() {

        CustomerSession::logout();
        \Core\Http\Redirect::go('/');
    }

    private function setCustomerSession($account) {

        if (!is_array($account)) {
            $account = $account->toArray();
        }

        $keys = array_keys($account);
        foreach ($keys as $k) {
            CustomerSession::set($k, $account[$k]);
        }

        return $account;
    }

}
