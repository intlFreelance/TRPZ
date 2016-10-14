<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = ['id', 'paymentMethod', 'transactionId', 'customer_id'];
    
    function customer(){
        return $this->belongsTo('App\Customer');
    }
    function purchase(){
        return $this->hasOne('App\Purchase');
    }
}
