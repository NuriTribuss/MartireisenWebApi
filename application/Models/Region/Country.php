<?php

namespace Model\Region;

use \Illuminate\Database\Eloquent\Model;

class Country  extends Model {

    protected $table = 'region_countries';
    protected $fillable = array('name', 'code','phonecode','priority');

    public $timestamps = false;

}
