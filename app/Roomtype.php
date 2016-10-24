<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roomtype extends Model {
    
    public $timestamps = false;
    
    function hotelRoomtypes() {
        return $this->hasMany('App\HotelRoomtype');
    }
}