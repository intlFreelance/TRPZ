<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasePackage extends Model
{
     public $timestamps = false;
     protected $dates = ['startDate', 'endDate'];
     protected $dateFormat = 'Y-m-d';
     function package(){
         return $this->belongsTo('App\Package', 'packageId');
     }
     function hotel(){
         return $this->belongsTo('App\Hotel', 'hotelId');
     }
     function roomType(){
         return $this->belongsTo('App\Roomtype', 'roomTypeId');
     }
     function purchasePackageActivities(){
         return $this->hasMany('App\PurchasePackageActivity');
     }
}
