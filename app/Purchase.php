<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['id', 'transaction_id'];
    
    public $timestamps = false;
    
    function transaction(){
        return $this->belongsTo('App\Transaction');
    }
    function purchasePackages(){
        return $this->hasMany('App\PurchasePackage');
    }
}
