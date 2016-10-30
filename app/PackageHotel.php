<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageHotel extends Model
{
    public $timestamps = false;

    protected $fillable = ['hotelId'];
    
    function package() {
        return $this->belongsTo('App\Package', 'package_id');
    }
    function hotel(){
        return $this->belongsTo('App\Hotel', 'hotelId');
    }
    protected static function boot() {
        parent::boot();

        static::deleting(function($packageHotel) {
            Hotel::find($packageHotel->hotelId)->delete();
        });
    }
}
