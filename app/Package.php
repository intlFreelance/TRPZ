<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public $timestamps = false;
    
    function packageHotels() {
        return $this->hasMany('App\PackageHotel');
    }

    function packageActivities() {
        return $this->hasMany('App\PackageActivity');
    }
}
