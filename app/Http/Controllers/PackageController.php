<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\TouricoHotel;
use App\TouricoActivity;
use App\TouricoDestination;

class PackageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
        $this->currentDate = Carbon::now()->format('Y-m-d');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->request->session()->forget('destinations');
        $destinations = $this->request->session()->get('destinations', function() {
            $allDestinations = $this->getAllDestinations();
            $this->request->session()->put('destinations', $allDestinations);
            return $allDestinations;
        });

        $data = [
            'destinations' => $destinations->DestinationResult
        ];

        return view('create-package', $data);
    }

    private function getAllDestinations()
    {
        $destination_api = new TouricoDestination;
        $data = [
            'Destination'=>[
                'Continent'=>null,
                'StatusDate'=>'2016-09-10'
            ]
        ];
        return $destination_api->SearchDestinations($data);
    }

    public function getHotels() {
        $hotel_api = new TouricoHotel;
        $data = [
            'request'=>[
                'Destination'=>$this->request->query('destination'),
                'CheckIn'=>Carbon::parse($this->request->query('start-date'))->format('Y-m-d'),
                'CheckOut'=>Carbon::parse($this->request->query('end-date'))->format('Y-m-d'),
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
        $hotels = $hotel_api->SearchHotels($data);
        if(isset($hotels->Hotel) && !is_array($hotels->Hotel))
        {
            $hotels = ['Hotel'=>[$hotels->Hotel]];
        }
        return response()->json($hotels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
