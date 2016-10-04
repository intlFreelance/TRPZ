<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageHotel extends Model
{
    public $timestamps = false;

    protected $fillable = ['hotelId'];
    
    function package() {
        return $this->belongsTo('App\Package');
    }
}
