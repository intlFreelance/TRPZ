<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageActivity extends Model
{
    public $timestamps = false;

    protected $fillable = ['activityId'];
    
    function package() {
        return $this->belongsTo('App\Package', 'package_id');
    }
    function activity(){
        return $this->belongsTo('App\Activity', 'activityId');
    }
    protected static function boot() {
        parent::boot();

        static::deleting(function($packageActivity) {
            Activity::find($packageActivity->activityId)->delete();
        });
    }
}
