<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityOption extends Model
{
     function activity() {
        return $this->belongsTo('App\Activity');
    }
    public $timestamps = false;
    
}