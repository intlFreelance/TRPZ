<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    public $timestamps = false;

    protected $fillable = ['id','name', 'destinationId', 'provider', 'elementType', 'destinationCode','cityLatitude','cityLongitude','parent_destinationId','parent_id'];
}
