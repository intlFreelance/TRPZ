<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    function activityOptions(){
        return $this->hasMany('App\ActivityOption');
    }
    function packageActivity() {
        return $this->hasOne('App\PackageActivity','activityId');
    }
    public $timestamps = false;
    protected static function boot() {
        parent::boot();

        static::deleting(function($activity) {
             $activity->activityOptions()->delete();
        });
    }
}
