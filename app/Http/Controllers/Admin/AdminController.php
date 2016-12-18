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
          'HotelRoomTypeId'=>12543222,
          'CheckIn'=>'2017-01-13',
          'CheckOut'=>'2017-01-17',
          'RoomsInfo'=>[
            [
              'RoomId'=>1,
              'ContactPassenger'=>[
                'FirstName'=>'Lebron',
                'LastName'=>'James'
              ],
              'SelectedBoardBase'=>[
                'Id'=>1,
                'Price'=>0
              ],
              'SelectedSupplements'=>[
                (object) [
                  'suppId'=>1200028,
                  'supTotalPrice'=>'0.00',
                  'suppType'=>4
                ],
                (object) [
                  'suppId'=>1000615,
                  'supTotalPrice'=>'100.00',
                  'suppType'=>8,
                  'SupAgeGroup'=>[
                    (object) [
                      'suppFrom'=>1,
                      'suppTo'=>7,
                      'suppQuantity'=>1,
                      'suppPrice'=>'20.00'
                    ],
                    (object) [
                      'suppFrom'=>8,
                      'suppTo'=>99,
                      'suppQuantity'=>2,
                      'suppPrice'=>'40.00'
                    ]
                  ]
                ],
              ],
              'AdultNum'=>'2',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>4)
              ]
            ],
            [
              'RoomId'=>2,
              'ContactPassenger'=>[
                'FirstName'=>'Lebron',
                'LastName'=>'James'
              ],
              'SelectedBoardBase'=>[
                'Id'=>1,
                'Price'=>0
              ],
              'SelectedSupplements'=>[
                (object) [
                  'suppId'=>1200028,
                  'supTotalPrice'=>'0.00',
                  'suppType'=>4
                ],
                (object) [
                  'suppId'=>1000615,
                  'supTotalPrice'=>'120.00',
                  'suppType'=>8,
                  'SupAgeGroup'=>[
                    (object) [
                      'suppFrom'=>8,
                      'suppTo'=>99,
                      'suppQuantity'=>3,
                      'suppPrice'=>'40.00'
                    ]
                  ]
                ]
              ],
              'AdultNum'=>'3',
              'ChildNum'=>'0'
            ],
            [
              'RoomId'=>3,
              'ContactPassenger'=>[
                'FirstName'=>'Lebron',
                'LastName'=>'James'
              ],
              'SelectedBoardBase'=>[
                'Id'=>1,
                'Price'=>0
              ],
              'SelectedSupplements'=>[
                (object) [
                  'suppId'=>1200028,
                  'supTotalPrice'=>'0.00',
                  'suppType'=>4
                ],
                (object) [
                  'suppId'=>1000615,
                  'supTotalPrice'=>'60.00',
                  'suppType'=>8,
                  'SupAgeGroup'=>[
                    (object) [
                      'suppFrom'=>1,
                      'suppTo'=>7,
                      'suppQuantity'=>1,
                      'suppPrice'=>'20.00'
                    ],
                    (object) [
                      'suppFrom'=>8,
                      'suppTo'=>99,
                      'suppQuantity'=>1,
                      'suppPrice'=>'40.00'
                    ]
                  ]
                ],
              ],
              'AdultNum'=>'1',
              'ChildNum'=>'1',
              'ChildAges'=>[
                (object) array('age'=>6)
              ]
            ]
          ],
          'PaymentType'=>'Obligo',
          'RequestedPrice'=>'2570.49',
          'DeltaPrice'=>'25.70',
          'IsOnlyAvailable'=>True,
          'Currency'=>'USD',
          'AgentRefNumber'=>'123NA'
        ]
      ];
      dd($hotel_api->book($data));
    }
    public function bookActivity(){
        $activity_api = new TouricoActivity();
        $data = [
            "BookActivityOptions"=>[
                "orderInfo"=>(object)[
                    "rgRefNum"=>"0",
                    "requestedPrice"=>"252.2", //TODO: Where do I get this from
                    "currency"=>"USD",
                    //"confirmationLogoUrl"=>"http://www.touricoholidays.com/logos/touricoholidays.jpg",
                    "paymentType"=>"Obligo",
                    "recordLocatorId"=>"0",
                    //"confirmationEmail"=>"john.pass@yahoo.com",
                    //"agentRefNumber"=>"123NA",
                    "DeltaPrice"=> (object)[
                        "basisType"=>"Percent",
                        "value"=>"1"
                    ]
                ],
                "reservations"=>[
                    "ActivitiesInfo"=>[
                        (object)[
                            "activityId"=>"1219169",
                            "optionId"=>"15023436",
                            "date"=>"2017-01-15",
                            "ActivityPricing"=> (object)[
                                "price"=>"252.2",
                                "currency"=>"USD",
                                "tax"=>"0",
                                "PriceBreakdown"=>[
                                    "Adult"=>(object)[
                                        "numbers"=>"2",
                                        "amount"=>"126.1"
                                    ]
                                ]
                            ],
                            "CancellationPolicy"=>[
                                "CancellationPenalties"=>[
                                    (object)[
                                        "Deadline"=>(object)[
                                            "offsetUnit"=>"Always",
                                            "unitsFromCheckIn"=>"1"
                                        ],
                                        "Penalty"=>(object)[
                                            "basisType"=>"Percent",
                                            "value"=>"100"
                                        ]
                                    ]
                                ]
                            ],
                            "ActivityAdditions"=>[
                                "TextAdditions"=>[
                                    (object)[
                                        "additionTypeID"=>"21534",
                                        "additionType"=>"Guest contact phone number including country code?",
                                        "value"=>"+1 352-123-4567"
                                    ]
                                ]
                            ],
                            "Passengers"=>[
                                (object)[
                                    "mobilePhone"=>"111111111",
                                    "homePhone"=>"222222222",
                                    "isMainContact"=>"true",
                                    "seatNumber"=>"",
                                    "lastName"=>"Pass",
                                    "type"=>"Adult",
                                    "seqNumber"=>"1",
                                    "middleName"=>"Anderson",
                                    "firstName"=>"John"
                                ],
                                (object)[
                                    "mobilePhone"=>"111111111",
                                    "homePhone"=>"222222222",
                                    "isMainContact"=>"false",
                                    "seatNumber"=>"",
                                    "lastName"=>"Pass",
                                    "type"=>"Adult",
                                    "seqNumber"=>"1",
                                    "middleName"=>"Alison",
                                    "firstName"=>"Jane"
                                ]
                            ],
                            //"SpecialRequests"=>"We will arrive at 15:00. Thanks."
                        ]
                    ]
                ]
            ]
        ];
        dd($activity_api->Book($data));
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
