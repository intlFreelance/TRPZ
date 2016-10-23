<?php

namespace App;

use App\Notifications\CustomerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $hidden = array('password','remember_token');
    
    protected $fillable = ['id','firstName','lastName', 'email', 'password', 'address'];
    
    protected $casts = [
        'address' => 'array',
    ];
    function transactions(){
        return $this->hasMany('App\Transaction');
    }
    function getFullName(){
        return "{$this->firstName} {$this->lastName}";
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPassword($token));
    }
}