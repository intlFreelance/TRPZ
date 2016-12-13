<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TouricoHotel;
use App\TouricoActivity;
use App\TouricoDestination;

class AdminController extends Controller
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
      return view('admin.home');
    }

    // public function hotels()
    // {
    //   $hotel_api = new TouricoHotel;
    //   $data = [
    //     'HotelIds'=>[
    //         (object) array('hotelId'=>1203719)
    //       ]
    //   ];
    //   dd($hotel_api->getHotelDetailsV3($data));
    // }

    public function hotels()
    {
      $hotel_api = new TouricoHotel;
      $data = [
        'request'=>[
          'HotelIdsInfo'=>[
            (object) array('id' => 964)
          ],
          'CheckIn'=>'2017-01-13',
          'CheckOut'=>'2017-01-17',
          'RoomsInformation'=>[
            'RoomInfo'=>[
              'AdultNum'=>'2',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>4)
              ]
            ],
          ],
          'MaxPrice'=>'0',
          'StarLevel'=>'0',
          'AvailableOnly'=>'true',
          'PropertyType'=>'NotSet',
          'ExactDestination'=>'true'
        ]
      ];
      dd($hotel_api->SearchHotels($data));
    }

    public function hotelsById()
    {
      $hotel_api = new TouricoHotel;
      $data = [
        'request'=>[
          'HotelIdsInfo'=>[
            (object) array('id' => 964)
          ],
          'CheckIn'=>'2017-01-13',
          'CheckOut'=>'2017-01-17',
          'RoomsInformation'=>[
            'RoomInfo'=>[
              'AdultNum'=>'2',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>4)
              ]
            ],
            'RoomInfo'=>[
              'AdultNum'=>'3',
              'ChildNum'=>'0',
            ],
            'RoomInfo'=>[
              'AdultNum'=>'1',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>6)
              ]
            ],
          ],
          'MaxPrice'=>'0',
          'StarLevel'=>'0',
          'AvailableOnly'=>'true',
          'PropertyType'=>'NotSet',
          'ExactDestination'=>'true'
        ]
      ];
      dd($hotel_api->SearchHotelsById($data));
    }

    public function hotelDetails()
    {
      $hotel_api = new TouricoHotel;
      $data = [
        'HotelIds'=>[
            (object) array('id' => 1320286)
        ]
      ];
      dd($hotel_api->getHotelDetailsV3($data));
    }

    public function hotelCancellation() {
      $hotel_api = new TouricoHotel();
      $data = [
          "nResId"=>0,
          "hotelId"=>964,
          "hotelRoomTypeId"=>12543222,
          "dtCheckIn"=>'2017-01-13',
          "dtCheckOut"=>'2017-01-17'
      ];
      dd($hotel_api->GetCancellationPolicies($data));
    }

    public function checkPrices()
    {
      $hotel_api = new TouricoHotel;
      $data = [
        'request'=>[
          'HotelIdsInfo'=>[
            (object) array('id' => 964)
          ],
          'CheckIn'=>'2017-01-13',
          'CheckOut'=>'2017-01-17',
          'RoomsInformation'=>[
            'RoomInfo'=>[
              'AdultNum'=>'2',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>4)
              ]
            ],
            'RoomInfo'=>[
              'AdultNum'=>'3',
              'ChildNum'=>'0',
            ],
            'RoomInfo'=>[
              'AdultNum'=>'1',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>6)
              ]
            ],
          ],
          'MaxPrice'=>'0',
          'StarLevel'=>'0',
          'AvailableOnly'=>'true',
          'PropertyType'=>'NotSet',
          'ExactDestination'=>'true'
        ]
      ];
      dd($hotel_api->CheckAvailabilityAndPrices($data));
    }

    public function book() {
      $hotel_api = new TouricoHotel();
      $data = [
        'request'=>[
          'RecordLocatorId'=>0,
          'HotelId'=>964,
          'hotelRoomTypeId'=>12543222,
          'CheckIn'=>'2017-01-13',
          'CheckOut'=>'2017-01-17',
          'RoomsInfo'=>[
            'RoomReserveInfo'=>[
              'RoomId'=>1,
              'ContactPassenger'=>[
                'FirstName'=>'Lebron',
                'LastName'=>'James'
              ]
              'SelectedBoardBase'=>[
                'Id'=>1
                'Price'=>0
              ],
              'SelectedSupplements'=>[
                'SupplementInfo'=> (object) [
                  'suppId'=>1200028,
                  'supTotalPrice'=>'0.00',
                  'suppType'=>4
                ],
                'SupplementInfo'=> (object) [
                  'suppId'=>1000615,
                  'supTotalPrice'=>'60.00',
                  'suppType'=>8
                ],
              ],
              'AdultNum'=>'1',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>6)
              ]
            ],
            'RoomReserveInfo'=>[
              'RoomId'=>1,
              'ContactPassenger'=>[
                'FirstName'=>'Lebron',
                'LastName'=>'James'
              ]
              'SelectedBoardBase'=>[
                'Id'=>1
                'Price'=>0
              ],
              'SelectedSupplements'=>[
                'SupplementInfo'=> (object) [
                  'suppId'=>1200028,
                  'supTotalPrice'=>'0.00',
                  'suppType'=>4
                ],
                'SupplementInfo'=> (object) [
                  'suppId'=>1000615,
                  'supTotalPrice'=>'60.00',
                  'suppType'=>8
                ],
              ],
              'AdultNum'=>'1',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>6)
              ]
            ],
            'RoomReserveInfo'=>[
              'RoomId'=>1,
              'ContactPassenger'=>[
                'FirstName'=>'Lebron',
                'LastName'=>'James'
              ]
              'SelectedBoardBase'=>[
                'Id'=>1
                'Price'=>0
              ],
              'SelectedSupplements'=>[
                'SupplementInfo'=> (object) [
                  'suppId'=>1200028,
                  'supTotalPrice'=>'0.00',
                  'suppType'=>4
                ],
                'SupplementInfo'=> (object) [
                  'suppId'=>1000615,
                  'supTotalPrice'=>'60.00',
                  'suppType'=>8
                ],
              ],
              'AdultNum'=>'1',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>6)
              ]
            ],
          ],
          'PaymentType'=>'Obligo',
          'RequestPrice'=>'2326.50',
          'Currency'=>'USD'
        ]
      ];
      dd($hotel_api->book($data));
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
          'Country'=>'USA',
          'State'=>'New York',
          'City'=>'New York',
          'StatusDate'=>'2012-09-01',
        ]
      ];
      $res = $destination_api->SearchDestinations($data);
      $hotels = $res->DestinationResult
                    ->Continent
                    ->Country
                    ->State
                    ->City
                    ->Hotels
                    ->Hotel;
      dd($hotels);
      // $deals = [];
      // foreach($hotels as $hotel) {
      //   if($hotel->bestVal) {
      //     $deals[] = $hotel;
      //   }
      // }
      // dd($deals);
    }
}
