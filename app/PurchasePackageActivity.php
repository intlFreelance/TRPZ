<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasePackageActivity extends Model
{
     public $timestamps = false;
     function activity(){
         return $this->belongsTo('App\Activity', 'activityId');
     }
     function purchasePackage(){
         return $this->belongsTo('App\PurchasePackage');
     }
     function purchasePackageActivityOptions(){
         return $this->hasMany('App\PurchasePackageActivityOption');
     }
}
