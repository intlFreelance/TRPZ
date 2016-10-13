<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $hidden = array('password');
    
    protected $fillable = ['id','firstName','lastName', 'email', 'password', 'address'];
    
    protected $casts = [
        'address' => 'array',
    ];
}