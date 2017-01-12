<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    protected $dates = ['startDate', 'endDate'];
    protected $dateFormat = 'Y-m-d';

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
    public function getRetailPrice($formatted=true){
        $hotel = $this->packageHotels[0]->hotel;
        $price = round($hotel->minAverPrice * $this->numberOfDays * (1 + $this->retailMarkupPercentage/100),2);
        if($formatted){
            $price = "$ ".number_format($price, 2);
        }
        return $price;
    }
    public function getTrpzPrice($formatted=true){
        $hotel = $this->packageHotels[0]->hotel;
        $price = round($hotel->minAverPrice * $this->numberOfDays * (1 + $this->trpzMarkupPercentage/100), 2);
        if($formatted){
            $price = "$ ".number_format($price, 2);
        }
        return $price;
    }
    public function getJetSetGoPrice($formatted=true){
        $hotel = $this->packageHotels[0]->hotel;
        $price = round($hotel->minAverPrice * $this->numberOfDays * (1 + $this->jetSetGoMarkupPercentage/100),2);
        if($formatted){
            $price = "$ ".number_format($price, 2);
        }
        return $price;
    }
}
