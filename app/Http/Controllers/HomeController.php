<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TouricoHotel;
use App\TouricoActivity;
use App\TouricoDestination;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('home');
    }

    public function hotels()
    {
      $hotel_api = new TouricoHotel;
      $data = [
        'request'=>[
          'Destination'=>'NYC',
          'CheckIn'=>'2016-10-10',
          'CheckOut'=>'2016-10-12',
          'RoomsInformation'=>[
            'RoomInfo'=>[
              'AdultNum'=>'2',
              'ChildNum'=>'0'
            ]
          ],
          'MaxPrice'=>'0',
          'StarLevel'=>'0',
          'AvailableOnly'=>'true',
          'PropertyType'=>'NotSet',
          'ExactDestination'=>'true'
        ]
      ];
      print_r($hotel_api->SearchHotels($data));
    }

    public function activities()
    {
      $activity_api = new TouricoActivity;
      $data = [
        'SearchRequest'=>[
          'fromDate'=>'2016-10-10',
          'toDate'=>'2016-10-12',
          'destinationIds'=>[
            'int'=>'7647'
          ]
        ]
      ];
      print_r($activity_api->SearchActivityByDestinationIds($data));
    }

    public function destinations()
    {
      $destination_api = new TouricoDestination;
      //print_r($destination_api->functions());exit;
      $data = [
        'Destination'=>[
          'Continent'=>'North America',
          'StatusDate'=>'2016-09-10',
        ]
      ];
      print_r($destination_api->SearchDestinations($data));
    }
}
