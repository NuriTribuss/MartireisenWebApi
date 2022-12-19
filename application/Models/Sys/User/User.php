<?php

namespace Model\Sys\User;

use \Illuminate\Database\Eloquent\Model;

class User  extends Model {

    protected $table = 'users';
    protected $hidden = ['password','passwordkey','avatar'];
   
}
