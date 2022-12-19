<?php

namespace Model\Region\Defaults;

use \Illuminate\Database\Eloquent\Model;

class State  extends Model{

    protected $table    = 'states';
    protected $fillable = array('name', 'code','country_code');

    public $timestamps = false;


}
