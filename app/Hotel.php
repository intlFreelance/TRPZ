<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model{
    
    function packageHotels() {
        return $this->hasMany('App\PackageHotel');
    }
    
    function hotelRoomtypes(){
        return $this->hasMany('App\HotelRoomtype');
    }
    
    public $timestamps = false;
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($hotel) {
            foreach($hotel->hotelRoomtypes as $hotelRoomtype){
                HotelRoomtype::find($hotelRoomtype->id)->delete();
            }
        });
    }
    
    
}