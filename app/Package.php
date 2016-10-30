<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at', 'startDate', 'endDate', 'dealEndDate'];
    
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public $timestamps = false;
    
    function packageHotels() {
        return $this->hasMany('App\PackageHotel');
    }

    function packageActivities() {
        return $this->hasMany('App\PackageActivity');
    }
    public function categoriesNames(){
        $categoriesNames = "";
        foreach($this->categories as $category){
            $categoriesNames .= "$category->name, ";
        }
        return rtrim($categoriesNames,', ' );
    }
}
