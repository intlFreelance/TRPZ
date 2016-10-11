<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests;
use Carbon\Carbon;
use App\Category;
use App\Package;
use App\PackageHotel;
use App\PackageActivity;
use App\Destination;
use App\TouricoHotel;
use App\TouricoActivity;
use App\TouricoDestination;
use App\Hotel;
use App\Activity;
use App\ActivityOption;
use Session;

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
      $data["packages"] = Package::all();
      return view('admin.packages.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' => Category::all()
        ];

        return view('admin.packages.create', $data);
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

    public function jsonDestinations($continent=null,$country=null,$state=null)
    {
        if($continent == null){
          $destinations = Destination::where('elementType','8')->get();
        }else{
          if($country == null){
            $destinations = Destination::where('elementType','7')->where('parent_id',$continent)->get();
          }else{
            if($state == null){
              $destinations = Destination::where('elementType','6')->where('parent_id',$country)->get();
            }else{
              $destinations = Destination::where('elementType','3')->where('parent_id',$state)->get();
            }
          }
        }
        return response()->json($destinations);
    }

    public function updateDestinations()
    {
        Destination::truncate();
        echo "Destinations Truncateded...<br>";
        $destination_api = new TouricoDestination;
        $data = [
            'Destination'=>[
                'Continent'=>null,
                'StatusDate'=>date('Y-m-d',strtotime('-2 years'))
            ]
        ];
        $destination_response = $destination_api->SearchDestinations($data);
        $data = $this->parseDestinations($destination_response);
        echo "Destinations Successfully Updated";
    }

    private function parseDestinations($destination_response){
      foreach($destination_response->DestinationResult->Continent as $continent){
        $continent_destination = Destination::firstOrNew([
          'name'          => $continent->name,
          'destinationId' => $continent->destinationId,
          'provider'      => ($continent->provider!="")?$continent->provider:'0',
          'elementType'   => $continent->elementType,
        ]);
        $continent_destination->save();
        if(isset($continent->Country)){

          if(count($continent->Country) > 1){
            $countries = $continent->Country;
          }else{
            $countries = [$continent->Country];
          }

          foreach($countries as $country){
            $country_destination = Destination::firstOrNew([
              'name'                  => $country->name,
              'destinationId'         => $country->destinationId,
              'provider'              => ($country->provider!="")?$country->provider:'0',
              'elementType'           => $country->elementType,
              'parent_destinationId'  => $continent_destination->destinationId,
              'parent_id'             => $continent_destination->id,
            ]);
            $country_destination->save();
            if(isset($country->State)){

              if(count($country->State) > 1){
                $states = $country->State;
              }else{
                $states = [$country->State];
              }

              foreach($states as $state){
                $state_destination = Destination::firstOrNew([
                  'name'                  => ($state->name!="")?$state->name:'N/A',
                  'destinationId'         => $state->destinationId,
                  'provider'              => ($state->provider!="")?$state->provider:'0',
                  'elementType'           => $state->elementType,
                  'parent_destinationId'  => $country_destination->destinationId,
                  'parent_id'             => $country_destination->id,
                ]);
                $state_destination->save();
                if(isset($state->City)){

                  if(count($state->City) > 1){
                    $cities = $state->City;
                  }else{
                    $cities = [$state->City];
                  }

                  foreach($cities as $city){
                    $city_destination = Destination::firstOrNew([
                      'name'                  => $city->name,
                      'destinationId'         => $city->destinationId,
                      'provider'              => ($city->provider!="")?$city->provider:'0',
                      'destinationCode'       => $city->destinationCode,
                      'elementType'           => $city->elementType,
                      'cityLatitude'          => $city->cityLatitude,
                      'cityLongitude'         => $city->cityLongitude,
                      'parent_destinationId'  => $state_destination->destinationId,
                      'parent_id'             => $state_destination->id,
                    ]);
                    $city_destination->save();
                  }
                }
              }
            }
          }
        }
      }
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

    public function getActivities() {
        $activity_api = new TouricoActivity;
        $data = [
            'SearchRequest'=>[
                'fromDate'=>Carbon::parse($this->request->query('start-date'))->format('Y-m-d'),
                'toDate'=>Carbon::parse($this->request->query('end-date'))->format('Y-m-d'),
                'destinationIds'=>[
                    'int'=>$this->request->query('destination-id')
                ]
            ]
        ];
        $activities = $activity_api->SearchActivityByDestinationIds($data);
        if(isset($activities->Category) && !is_array($activities->Category))
        {
            $activities = ['Category'=>[$activities->Category]];
        }
        return response()->json($activities);
    }
    
    public function ajaxGetPackage($id){
        $package = Package::find($id);
        $category = $package->categories[0];
        $activities = [];
        $hotels=[];
        foreach($package->packageHotels as $packageHotel){
            $hotels[] = Hotel::find($packageHotel->hotelId);
        }
        foreach($package->packageActivities as $packageActivity){
            $activity = Activity::find($packageActivity->activityId);
            $activities[] = $activity;
        }
        $response = ["package"=>$package, "category"=>$category, "hotels"=>$hotels, "activities"=>$activities];
        return response()->json($response);
    }
    /**
     * Save a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSavePackage()
    {
        $data = \Illuminate\Support\Facades\Input::all();
        $file = $data["imgUpload"];
        $newPackage = json_decode($data["newPackage"], true);
        $isNewRecord = empty($newPackage["id"]);
        if($isNewRecord){
            $package = new Package;
        }else{
            $package = Package::find($newPackage["id"]);
        }
        $package->name = $newPackage['name'];
        $package->description = $newPackage['description'];
        $package->numberOfDays = $newPackage['numberOfDays'];
        $package->startDate = $newPackage['startDate'];
        $package->endDate = $newPackage['endDate'];
        $package->numberOfPeople = $newPackage['numberOfPeople'];
        $package->dealEndDate = $newPackage['dealEnd'];
        $package->retailPrice = $newPackage['retailPrice'];
        $package->trpzPrice = $newPackage['trpzPrice'];
        $package->jetSetGoPrice = $newPackage['jetSetGoPrice'];
        $package->save();
        if($isNewRecord){
            $category = Category::find($newPackage['categoryId']);
            $package->categories()->save($category);
        }else{
            if($package->categories[0]->id != $newPackage["categoryId"]){
                $package->categories()->detach();
                $category = Category::find($newPackage['categoryId']);
                $package->categories()->save($category);
            }
        }
        foreach($package->packageHotels as $packageHotel){
            $dbHotel = Hotel::find($packageHotel->hotelId);
            $found = false;
            foreach($newPackage['hotels'] as $key => $hotel){
                if($hotel["hotelId"] == $dbHotel->hotelId){
                    $found = true;
                    unset($newPackage['hotels'][$key]);
                    break;
                }
            }
            if(!$found){
                PackageHotel::find($packageHotel->id)->delete();
            }
        }
        $hotelIds = [];
        forEach($newPackage['hotels'] as $hotel) {
            $newHotel = new Hotel;
            $newHotel->hotelId = $hotel["hotelId"];
            $newHotel->name = $hotel["name"];
            $newHotel->countryCode = $hotel["Location"]["countryCode"];
            $newHotel->stateCode = $hotel["Location"]["stateCode"];
            $newHotel->city = $hotel["Location"]["city"];
            $newHotel->address = $hotel["Location"]["address"];
            $newHotel->longitude = $hotel["Location"]["longitude"];
            $newHotel->latitude = $hotel["Location"]["latitude"];
            $newHotel->category = $hotel["category"];
            $newHotel->minAverPrice = $hotel["minAverPrice"];
            $newHotel->currency = $hotel["currency"];
            $newHotel->thumb = $hotel["thumb"];
            $newHotel->starsLevel = $hotel["starsLevel"];
            $newHotel->description = $hotel["desc"];
            $newHotel->save();
            
            $hotelIds[] = new PackageHotel(['hotelId'=>$newHotel->id]);
        }
        $package->packageHotels()->saveMany($hotelIds);
        
        foreach($package->packageActivities as $packageActivity){
            $dbActivity = Activity::find($packageActivity->activityId);
            $found = false;
            foreach($newPackage['activities'] as $key => $activity){
                if($activity["activityId"] == $dbActivity->activityId){
                    $found = true;
                    unset($newPackage['activities'][$key]);
                    break;
                }
            }
            if(!$found){
                PackageActivity::find($packageActivity->id)->delete();
            }
        }
        $activityIds = [];
        foreach($newPackage['activities'] as $activity){
            $newActivity = new Activity;
            $newActivity->activityId = $activity["activityId"];
            $newActivity->name = $activity["name"];
            $newActivity->currency = $activity["currency"];
            $newActivity->thumbURL = $activity["thumbURL"];
            $newActivity->countryCode = $activity["countryCode"];
            $newActivity->city = $activity["city"];
            $newActivity->address = $activity["address"];
            $newActivity->starsLevel = $activity["starsLevel"];
            $newActivity->description = $activity["description"];
            $newActivity->save();
            foreach($activity["options"] as $activityOption){
                $newActivityOption = new ActivityOption;
                $newActivityOption->name = $activityOption["name"];
                $newActivityOption->type = $activityOption["type"];
                $newActivityOption->adultPrice = $activityOption["availabilities"][0]["adultPrice"];
                $newActivityOption->childPrice = $activityOption["availabilities"][0]["childPrice"];
                $newActivityOption->unitPrice = $activityOption["availabilities"][0]["unitPrice"];
                $newActivityOption->activity_id = $newActivity->id;
                $newActivityOption->save();
            }
            $activityIds[] = new PackageActivity(['activityId'=>$newActivity->id]);
        }
        $package->packageActivities()->saveMany($activityIds);
        if (!empty($file) && $file != "undefined") {
            $ext = $file->getClientOriginalExtension();
            $imageName = str_random(15).'.'.$ext;
            if (!file_exists(public_path().'/uploads/packages')) {
                mkdir(public_path().'/uploads/packages',0777, true);
            }
            if(!$isNewRecord && isset($package->mainImage)){
                unlink(public_path().'/uploads/packages/'.$package->mainImage);
            }
            Image::make($file)->save(public_path().'/uploads/packages/'.$imageName);
            $package->mainImage = $imageName;
            $package->save();
        }
        
        return response()->json($package->id);
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
        $package = Package::find($id);
        $data = [
            'categories' => Category::all()
        ];
        if (empty($package)) {
            Session::flash('error','Package not found');
            return redirect(route('admin.packages.index'));
        }
        return view('admin.packages.edit',$data)->with('package', $package);
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
        $package = Package::find($id);

        if (empty($package)) {
          Session::flash('error','Package not found');
          return redirect(route('packages.index'));
        }
        Package::find($id)->delete();
        if(!empty($package->mainImage)){
            $imgPath = public_path().'/uploads/packages/'.$package->mainImage;
            if(file_exists($imgPath)){
                unlink($imgPath);
            }
        }
        Session::flash('success','Package deleted successfully.');
        return redirect(route('packages.index'));
    }
}
