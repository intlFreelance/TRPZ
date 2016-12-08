<?php

namespace App;

use Artisaninweb\SoapWrapper\Extension\SoapService;
use Exception;
class PerRoomSupplement{}
class PerPersonSupplement{} 
class TouricoHotel extends SoapService {
    
    /**
     * @var string
     */
    protected $name = 'hotel';

    /**
     * @var boolean
     */
    protected $trace = true;

    /**
     * Construct the Model
     *
     * @return mixed
     */
    protected $options = [
        "classmap" => [
            "PerRoomSupplement" => "App\PerRoomSupplement",
            "PerPersonSupplement" => "App\PerPersonSupplement"
        ],
    ];

    public function __construct(){
        if(empty(config('tourico.hotel_wsdl'))){
            throw new Exception("The variable 'tourico.wsdl' must be set.");
        }
        if(empty(config('tourico.hotel_header'))){
            throw new Exception("The variable 'tourico.hotel_header' must be set.");
        }
        $this->wsdl(config('tourico.hotel_wsdl'))->createClient();
        $this->header('http://schemas.tourico.com/webservices/authentication','AuthenticationHeader',config('tourico.hotel_header'));
    }

    /**
     * Get all the available functions
     *
     * @return mixed
     */
    public function functions(){
        return $this->getFunctions();
    }

    public function SearchHotels($data){        
        return $this->call('SearchHotels',[$data])->SearchHotelsResult->HotelList;
    }
    public function SearchHotelsById($data){
        return $this->call('SearchHotelsById',[$data])->SearchHotelsByIdResult->HotelList->Hotel;
    }
    public function GetCancellationPolicies($data){
        return $response = $this->call('GetCancellationPolicies',[$data]);
    }
}
