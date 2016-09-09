<?php

namespace App;

use Artisaninweb\SoapWrapper\Extension\SoapService;

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
    public function __construct()
    {
        if(!empty(config('tourico.hotel_wsdl')))
        {
            $this->wsdl(config('tourico.hotel_wsdl'))
                 ->createClient();

            return;
        }
        throw new Exception("The variable 'wsdl' must be set.");
    }

    /**
     * Get all the available functions
     *
     * @return mixed
     */
    public function functions()
    {
        return $this->getFunctions();
    }

    public function SearchHotels($data)
    {
        $this->header('http://schemas.tourico.com/webservices/authentication','AuthenticationHeader',config('tourico.hotel_header'));
        return $this->call('SearchHotels',[$data])->SearchHotelsResult->HotelList;
    }

}
