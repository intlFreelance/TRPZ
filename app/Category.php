<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['id','name','image'];


    public function packages()
    {
        return $this->belongsToMany('App\Package');
    }
    
    public static function getHomePageCategories(){
         return static::where('name', '<>', 'Other')->where('name', '<>', 'Featured')->get();
    }
    
}
