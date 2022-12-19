<?php

namespace Model\Log;

use \Illuminate\Database\Eloquent\Model;

class Admin  extends Model {

    protected $table = 'sys_log';
    
    public static function log($opts) {
        
        $log = new Admin();
        $log->author           = \Model\User\Admin::getFullName();
        $log->author_id        = 1;
        
        $log->module         = $opts['module'];
        $log->module_code    = (string)$opts['module_code'];
        $log->message        = (string)$opts['message'];
        $log->ip             = $_SERVER['REMOTE_ADDR'];
        
        return $log->save();
    }

}
