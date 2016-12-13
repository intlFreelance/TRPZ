<?php

namespace App;

use Artisaninweb\SoapWrapper\Extension\SoapService;

class TouricoDestination extends SoapService {

    /**
     * @var string
     */
    protected $name = 'destination';

    /**
     * @var boolean
     */
    protected $trace = false;

    /**
     * Construct the Model
     *
     * @return mixed
     */
    public function __construct()
    {
        if(!empty(config('tourico.destination_wsdl')))
        {
            $this->wsdl(config('tourico.destination_wsdl'))
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

    public function SearchDestinations($data)
    {
        $this->header('http://touricoholidays.com/WSDestinations/2008/08/DataContracts','LoginHeader',config('tourico.destination_header'));
        return $this->call('GetHotelsByDestination',[$data]);
    }

}
