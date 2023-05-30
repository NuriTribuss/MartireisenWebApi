<?php

namespace Model\Log;

use Application\Api\Auth;
use \Illuminate\Database\Eloquent\Model;

class Admin  extends Model {

    protected $table = 'sys_log';
    
    public static function log($opts,$user) {

        $log = new Admin();
        $log->author           = $user->firstname . ' ' . $user->lastname;
        $log->author_id        = $user->id;
        
        $log->module         = $opts['module'];
        $log->module_code    = (string)$opts['module_code'];
        $log->message        = (string)$opts['message'];
        $log->ip             = $_SERVER['REMOTE_ADDR'];
        
        return $log->save();
    }

}
