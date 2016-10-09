<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    function activityOptions(){
        return $this->hasMany('App\ActivityOption');
    }
    function packageActivities() {
        return $this->hasMany('App\PackageActivity');
    }
    public $timestamps = false;
    
}
