<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasePackage extends Model
{
     public $timestamps = false;
     function package(){
         return $this->belongsTo('App\Package');
     }
}
