<?php

namespace Model\Region\Defaults;

use \Illuminate\Database\Eloquent\Model;

class Country  extends Model {

    protected $table = 'countries';
    protected $fillable = array('name', 'code','phonecode','priority');

    public $timestamps = false;

}
