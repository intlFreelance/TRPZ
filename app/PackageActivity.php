<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageActivity extends Model
{
    public $timestamps = false;

    protected $fillable = ['activityId'];
    
    function package() {
        return $this->belongsTo('App\Package');
    }
}
