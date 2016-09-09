<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TouricoHotel;

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
}
