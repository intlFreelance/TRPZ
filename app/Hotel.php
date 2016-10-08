<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model{
    
    function packageHotels() {
        return $this->hasMany('App\PackageHotel');
    }
    
    public $timestamps = false;
    
    
}