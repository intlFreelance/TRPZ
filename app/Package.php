<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
