<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasePackageActivityOption extends Model
{
     public $timestamps = false;
     function activityOption(){
         return $this->belongsTo('App\ActivityOption', 'activity_optionId');
     }
     function purchasePackageActivity(){
         return $this->belongsTo('App\PurchasePackageActivity');
     }
}
