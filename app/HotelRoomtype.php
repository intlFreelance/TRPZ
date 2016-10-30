<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelRoomtype extends Model {
    
    public $timestamps = false;
    
    protected $fillable = ['roomTypeId'];
    function roomtype() {
        return $this->belongsTo('App\Roomtype', 'roomtypeId');
    }
    
    function hotel(){
        return $this->belongsTo('App\Hotel','hotel_id');
    }
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($hotelRoomtype) {
            Roomtype::find($hotelRoomtype->roomtypeId)->delete();
        });
    }
}