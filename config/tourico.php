<?php

$production = [
    // Production
    'hotel_wsdl'    => 'http://thfwsv3.touricoholidays.com/HotelFlow.svc?wsdl',
    'hotel_header'  => ['LoginName'=>'Fir106','Password'=>'@p6CxPBU','Culture'=>'en_US','Version'=>'7.123'],

    'activity_wsdl' => 'http://activityws.touricoholidays.com/ActivityBookFlow.svc?wsdl',
    'activity_header' => ['LoginName'=>'Fir106','Password'=>'@p6CxPBU','Culture'=>'en_US','Version'=>'7.123'],

    'destination_wsdl' => 'http://destservices.touricoholidays.com/DestinationsService.svc?wsdl',
    'destination_header' => ['username'=>'Fir106','password'=>'@p6CxPBU','culture'=>'en_US','version'=>'7.123'],
];

$demo = [
    // Demo
    'hotel_wsdl'    => 'http://demo-hotelws.touricoholidays.com/HotelFlow.svc?WSDL',
    'hotel_header'  => ['LoginName'=>'Fir110','Password'=>'111111','Culture'=>'en_US','Version'=>'7.123'],

    'activity_wsdl' => 'http://demo-activityws.touricoholidays.com/ActivityBookFlow.svc?wsdl',
    'activity_header' => ['LoginName'=>'fir123','Password'=>'111111','Culture'=>'en_US','Version'=>'7.123'],

    'destination_wsdl' => 'http://destservices.touricoholidays.com/DestinationsService.svc?wsdl',
    'destination_header' => ['username'=>'destinfirst','password'=>'Destination@18','culture'=>'en_US','version'=>'7.123']
];

// Returning Production only for the test sever
return $production;

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', trim($uri_path, '/'));

if($uri_segments[0] == 'admin') {
    return $production;
}

return $demo;


