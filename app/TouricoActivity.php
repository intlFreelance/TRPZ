<?php

namespace App;

use Artisaninweb\SoapWrapper\Extension\SoapService;

class TouricoActivity extends SoapService {

    /**
     * @var string
     */
    protected $name = 'activity';

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
        if(!empty(config('tourico.activity_wsdl')))
        {
            $this->wsdl(config('tourico.activity_wsdl'))
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

    public function SearchActivityByDestinationIds($data)
    {
        $this->header('http://schemas.tourico.com/webservices/authentication','AuthenticationHeader',config('tourico.activity_header'));
        return $this->call('SearchActivityByDestinationIds',[$data])->SearchActivityByDestinationIdsResult->Categories;
    }

    public function GetActivityDetails($data){
       $this->header('http://schemas.tourico.com/webservices/authentication','AuthenticationHeader',config('tourico.activity_header'));
       return $this->call('GetActivityDetails',[$data])->GetActivityDetailsResult->ActivitiesDetails;
    }
    
    public function ActivityPreBook($data){
       $this->header('http://schemas.tourico.com/webservices/authentication','AuthenticationHeader',config('tourico.activity_header'));
       return $this->call('ActivityPreBook',[$data])->ActivityPreBookResult->ActivitiesSelectedOptions;
    }

}
