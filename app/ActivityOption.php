<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityOption extends Model
{
     function activity() {
        return $this->belongsTo('App\Activity');
    }
    public function getPrice(){
        $package = $this->activity->packageActivity->package;
        $numberOfPeople = $package->numberOfPeople;
        $price = 0;
        if($this->type == "PerPerson"){
            $price = $this->adultPrice * $numberOfPeople;
        }else{
            $price = $this->unitPrice * $numberOfPeople;
        }
        return 
        [
            "retail"=>round($price * (1 + ($package->retailMarkupPercentage/100)),2),
            "trpz"=>round($price * (1 + ($package->trpzMarkupPercentage/100)),2),
            "jetSetGo"=>round($price * (1 + ($package->jetSetGoMarkupPercentage/100)),2)
            
        ];
    }
    public $timestamps = false;
    
}