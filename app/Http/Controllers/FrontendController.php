<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\Activity;
use App\ActivityOption;
use App\Category;
use App\Package;
use App\Hotel;
use App\Roomtype;
use App\Transaction;
use App\Purchase;
use App\PurchasePackage;
use App\PurchasePackageActivity;
use App\PurchasePackageActivityOption;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\TouricoHotel;
use App\TouricoActivity;
use Exception;
use Session;
use App\Authorize;
use stdClass;

class FrontendController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;   
    }
    
    public function index()
    {
        $data['categories'] = Category::getHomePageCategories();
        return view('frontend.home', $data);
    }

    public function about()
    {
      return view('frontend.about');
    }
    
    public function category($id){
        $data['category'] = Category::find($id);
        return view('frontend.category', $data);
    }
    public function package($categoryId, $id, $option=null, $parameter=null){
        ini_set('max_execution_time', 300);
        $data['category'] = Category::find($categoryId);
        $data['package'] = Package::find($id);
        $data['nonav'] = false;
        $data['noinputs'] = false;
        $data['voucher'] = null;
        foreach($data['package']->packageActivities as $key => $packageActivity) {
            $activity_api = new TouricoActivity;
            $activityDetailsRequest = [
                'ActivitiesIds'=>[
                    'ActivityId'=>[
                    'id'=>$packageActivity->activity->activityId
                    ]
                ]
            ];
            $data['package']
                ->packageActivities[$key]
                ->activity
                ->details = $activity_api->getActivityDetails($activityDetailsRequest);
        }
        if(isset($option)){
            switch ($option){
                case "nonav":
                    $data['nonav'] = true;
                    $data['noinputs'] = true;
                break;
                case "voucher":
                    $data['nonav'] = true;
                    $data['voucher'] = $parameter;
                break;   
            }
        }
        
        return view('frontend.package', $data);
    }
    public function getHotel($id){
        $hotel = Hotel::find($id);
        if(empty($hotel)){
            return response("Hotel not found.");
        }
        $roomTypes = [];
        foreach($hotel->hotelRoomtypes as $hotelRoomType){
            $roomTypes[] = Roomtype::find($hotelRoomType->roomtypeId);
        }
        return response()->json([
            'hotel'=>$hotel,
            'roomTypes'=>$roomTypes
        ]);
    }
    public function payment(){
        //final validation 
        if(Cart::count() == 0){
            Session::flash('danger',"There are no items in the cart yet.");
            return view('frontend.cart');
        }
        $packageRemoved = false;
        $hotel_api = new TouricoHotel();
        foreach(Cart::content() as $row){
            $package = Package::find($row->id);
            $hotelId = $package->packageHotels[0]->hotel->hotelId;
            $startDate = Carbon::parse($row->options->startDate)->format('Y-m-d');
            $endDate = Carbon::parse($row->options->endDate)->format('Y-m-d');
            $adultNum = $package->numberOfPeople;
            $roomTypeId = $row->options->roomTypeId;
            $activities = $row->options->activities;
            $hotelInCart = $row->options->hotel;
            $data = [
                'request'=>[
                    'HotelIdsInfo'=>[
                        'HotelIdInfo'=>['id'=>$hotelId]
                    ],
                    'CheckIn'=>$startDate,
                    'CheckOut'=>$endDate,
                    'RoomsInformation'=>[
                        'RoomInfo'=>[
                            'AdultNum'=>$adultNum,
                            'ChildNum'=>'0'
                        ]
                    ],
                    'MaxPrice'=>'0',
                    'StarLevel'=>'0',
                    'AvailableOnly'=>'true'
                ]
            ];
            $hotel = $hotel_api->CheckAvailabilityAndPrices($data)->Hotel;
            //Checking room availability
            $roomTypes = $hotel->RoomTypes->RoomType;
            $roomType = null;
            if(is_array($roomTypes)){
                foreach($roomTypes as $iRoomType){
                    if($iRoomType->hotelRoomTypeId == $roomTypeId){
                        $roomType = $iRoomType;
                        break;
                    }
                }
            }else{
                $roomType = $roomTypes;
            }
            $roomAvailable = $roomType->isAvailable;
            $availabilities = [];
            if(is_array($roomType->AvailabilityBreakdown->Availability)){
                $availabilities = $roomType->AvailabilityBreakdown->Availability;
            }else{
                $availabilities = [$roomType->AvailabilityBreakdown->Availability];
            }
            foreach ($availabilities as $availability){
                $roomAvailable &= $availability->status;
            }
            //checking prices availabilities
            $actualPricesAndFees = $this->getHotelPriceDetails($hotel, $roomTypeId, $package, $activities);
            $previousPricesAndFees = $this->getHotelPriceDetails($hotelInCart, $roomTypeId, $package, $activities);
            $previousPrice =  floatval(str_replace(",", "", $previousPricesAndFees['prices']["price"]));
            $actualPrice = floatval(str_replace(",", "", $actualPricesAndFees['prices']["price"]));

            $priceAvailable = $previousPrice  === $actualPrice;
            if(!$roomAvailable || !$priceAvailable){
                if(!$roomAvailable){
                    Session::flash('danger',"We're sorry! The package {$package->name} was removed, the room selected is not available in the specified dates.");
                }else{
                    Session::flash('danger',"We're sorry! The package {$package->name} was removed due to a price change.");
                }
               Cart::remove($row->rowId);
               $packageRemoved = true;
            }
        }
        if($packageRemoved){
            return view('frontend.cart');
        }
        return view('frontend.payment');
    }
    public function makePayment(Request $request){
        ini_set('max_execution_time', 300);
        $this->validate($request, [
            'paymentMethod' => 'required|max:255',
            'nameOnCard' => 'required|max:255',
            'cardNumber' => 'required|max:16|min:13',
            'cardType'=> 'required',
            'expMonth' => 'required|numeric|between:1,12',
            'expYear' => 'required|numeric|between:'.date('Y').','.(date('Y') + 10),
            'securityCode' => 'required|size:3',
            'address.line1' => 'required',
            'address.city' => 'required',
            'address.state' => 'required',
            'address.zip' => 'required'
        ]);
        
        $input = $request->all();
        
        //Transaction created
        $transaction = new Transaction;
        $transaction->transactionId = md5(uniqid(rand(), true));
        $transaction->paymentMethod = $input["paymentMethod"];
        $transaction->customer_id = Auth::guard('customer')->user()->id;
        $transaction->save();
        
        //Purchase created
        $purchase = new Purchase;
        $purchase->transaction_id = $transaction->id;
        $purchase->save();
        
        $booking = [];
        $totalCharge = 0;
        //Purchase details
        foreach(Cart::content() as $row){
            //Hotel Booking
            $package = Package::find($row->id);
            $hotelBookingResult = new stdClass();
            $hotelBookingResult->hotel = $row->options->hotel;
            $hotelBookingResult->package = $package;
            $hotelBookingResult->activitiesBooking = [];
            try{
                $hotelBooking = $this->bookHotel($row);
                $hotelBookingResult->hotelBooking = $hotelBooking;
                $hotelBookingResult->success = true;
                
                $purchasePackage = new PurchasePackage;
                $purchasePackage->packageId = $row->id;
                $purchasePackage->purchase_id = $purchase->id;
                $purchasePackage->startDate = Carbon::parse($row->options->startDate)->format('Y-m-d');
                $purchasePackage->endDate = Carbon::parse($row->options->endDate)->format('Y-m-d');
                $purchasePackage->hotelId = $package->packageHotels[0]->hotel->id;
                $purchasePackage->roomTypeId = $row->options->roomTypeId;
                $purchasePackage->save();
            }catch(Exception $ex){
                $hotelBookingResult->success = false;
                $hotelBookingResult->message = $ex->getMessage();
                $hotelBookingResult->code = $ex->getCode();
            }         
            if(isset($hotelBookingResult->hotelBooking) && $hotelBookingResult->success){
                foreach($row->options->activities as $key => $activity){
                    //Activity Booking
                    $activityBookingResult = new stdClass();
                    $activityBookingResult->activity = $activity;
                    try{
                        $activityBooking = $this->bookActivity($activity);
                        $activityBookingResult->activityBooking = $activityBooking;
                        $activityBookingResult->success = true;
                        
                        $purchasePackageActivity = new PurchasePackageActivity;
                        $purchasePackageActivity->activityId = $activity->activityDbId;
                        $purchasePackageActivity->purchase_package_id = $purchasePackage->id;
                        $purchasePackageActivity->save();
                        
                        $purchasePackageActivityOption = new PurchasePackageActivityOption;
                        $purchasePackageActivityOption->activity_optionId = $activity->activityOptionDbId;
                        $purchasePackageActivityOption->purchase_package_activity_id = $purchasePackageActivity->id;
                        $purchasePackageActivityOption->save();
                    }catch(Exception $ex){
                        $activities = $row->options->activities;
                        unset($activities[$key]);
                        //$options = $row->options;
                        //$options["activities"] = $activities;
                        $pricesAndFees = $this->getHotelPriceDetails($row->options->hotel, $row->options->roomTypeId, $package, $activities);
                        $price =  floatval(str_replace(",", "", $pricesAndFees['prices'][$row->options->priceType]));
                        $row = Cart::update($row->rowId, ["price"=>$price]);
                        $activityBookingResult->success = false;
                        $activityBookingResult->message = $ex->getMessage();
                        $activityBookingResult->code = $ex->getCode();
                    }
                    $hotelBookingResult->activitiesBooking[] = $activityBookingResult;
                }
            }
            if($hotelBookingResult->success){
                $totalCharge += $row->price;
                Cart::remove($row->rowId);
            }
            $booking[] = $hotelBookingResult;
        }
        if($totalCharge == 0){
            Session::flash('danger',"There are no items in the cart yet.");
            return view('frontend.cart');
        }
        $expirationDate = str_pad($input["expMonth"], 2, "0").substr($input["expYear"], 2, 2);
        $paymentResponse = Authorize::chargeCreditCard($input['cardNumber'], $expirationDate, $input["securityCode"], $totalCharge);
        
        if(!$paymentResponse->success){
            //TODO: handle when credit card payment is declined
        }
        $transaction->transactionId = $paymentResponse->transID;
        $transaction->save();
        $data['purchase'] = $purchase;
        $data['booking'] = $booking;
        return view('frontend.confirmation', $data);
    }
    
    private function bookHotel($cartRow){
            $package = Package::find($cartRow->id);
            $hotelId = $package->packageHotels[0]->hotel->id;
            $dbhotel = Hotel::find($hotelId);
            $hotel = $cartRow->options->hotel;
            $startDate = Carbon::parse($cartRow->options->startDate)->format('Y-m-d');
            $endDate = Carbon::parse($cartRow->options->endDate)->format('Y-m-d');
            $roomTypeId = $cartRow->options->roomTypeId;
            $roomTypes = $hotel->RoomTypes->RoomType;
            $roomType = null;
            if(is_array($roomTypes)){
                foreach($roomTypes as $iRoomType){
                    if($iRoomType->hotelRoomTypeId == $roomTypeId){
                        $roomType = $iRoomType;
                        break;
                    }
                }
            }else{
                $roomType = $roomTypes;
            }
            if(is_array($roomType->Occupancies->Occupancy)){
                $ocupancy = $roomType->Occupancies->Occupancy[0];
            }else{
                $ocupancy = $roomType->Occupancies->Occupancy;
            }
            //dd($ocupancy);
            $price = $ocupancy->occupPublishPrice;
            $deltaPrice = round($price * 0.02, 2); 
            $currency = $dbhotel->currency;
            $boardBases = [];
            foreach($cartRow->options->boardBases as $bb){
                $boardBases[] = ['Id'=>$bb->bbId, 'Price'=>$bb->bbPublishPrice];
            }
            $data = [
                'request'=>[
                  'RecordLocatorId'=>0,
                  'HotelId'=>$dbhotel->hotelId,
                  'HotelRoomTypeId'=>$roomTypeId,
                  'CheckIn'=>$startDate,
                  'CheckOut'=>$endDate,
                  'RoomsInfo'=>[
                    [
                      'RoomId'=>0,
                      'ContactPassenger'=>[
                        'FirstName'=>Auth::guard('customer')->user()->firstName,
                        'LastName'=>Auth::guard('customer')->user()->lastName
                      ],
                      'SelectedBoardBase'=> isset($boardBases[0]) ? $boardBases[0] : null,
                      'SelectedSupplements'=> $cartRow->options->supplements,
                      'AdultNum'=>$package->numberOfPeople,
                      'ChildNum'=>'0',
                    ]
                  ],
                  'PaymentType'=>'Obligo',
                  'RequestedPrice'=>$price,
                  'DeltaPrice'=>$deltaPrice,
                  'IsOnlyAvailable'=>True,
                  'Currency'=>$currency,
                ]
          ];
            $hotel_api = new TouricoHotel();
            return $hotel_api->Book($data);
    }
    private function bookActivity($activity){
            $data = [
            "BookActivityOptions"=>[
                "orderInfo"=>(object)[
                    "rgRefNum"=>"0",
                    "requestedPrice"=>$activity->ActivityPricing->price, //TODO: Where do I get this from
                    "currency"=>"USD",
                    "paymentType"=>"Obligo",
                    "recordLocatorId"=>"0",
                    "DeltaPrice"=> (object)[
                        "basisType"=>"Percent",
                        "value"=>"2"
                    ]
                ],
                "reservations"=>["ActivitiesInfo"=>[$activity]]
            ]
        ];
            $activity_api = new TouricoActivity();
            return $activity_api->Book($data);
    }
    
    private function authorizePayment(){
        
    }
    public function confirmation($id){
        $purchase = Purchase::find($id);
        $data['purchase'] = $purchase;
        return view('frontend.confirmation', $data);
    }
    
    public function staticPackage($option=null, $parameter=null){
        $data['nonav'] = false;
        $data['voucher'] = false;
        if(isset($option)){
            switch ($option){
                case "nonav":
                    $data['nonav'] = true;
                break;
                case "voucher":
                    $data['voucher'] = true;
                break;   
            }
        }
         
        return view('frontend.static-package', $data);
    }
    public function getHotelPrice(){
        try{
            $package = Package::find($this->request->query('package-id'));
            $roomTypeId = $this->request->query('roomType-id');
            $hotelId=$this->request->query('hotel-id');
            $startDate = Carbon::parse($this->request->query('start-date'))->format('Y-m-d');
            $endDate = Carbon::parse($this->request->query('end-date'))->format('Y-m-d');
            $hotel = $this->getTouricoHotel($hotelId, $startDate, $endDate, $package->numberOfPeople);
            $activities = json_decode($this->request->query('activities'));
            
            $pricesAndFees = $this->getHotelPriceDetails($hotel, $roomTypeId, $package, $activities);
            return response()->json(['success'=>true, 'prices'=>$pricesAndFees['prices'], 'supplements'=>$pricesAndFees['supplements'], 'boardBases'=>$pricesAndFees['boardBases']]);
        }catch(Exception $ex){
            return response()->json(["success"=>false, "message"=>$ex->getMessage()]);
        }
    }
    private function getHotelPriceDetails($hotel, $roomTypeId, $package, $activities){
            $roomTypes = $hotel->RoomTypes->RoomType;
            $roomType = null;
            if(is_array($roomTypes)){
                foreach($roomTypes as $iRoomType){
                    if($iRoomType->hotelRoomTypeId == $roomTypeId){
                        $roomType = $iRoomType;
                        break;
                    }
                }
            }else{
                $roomType = $roomTypes;
            }
            if(is_array($roomType->Occupancies->Occupancy)){
                $ocupancy = $roomType->Occupancies->Occupancy[0];
            }else{
                $ocupancy = $roomType->Occupancies->Occupancy;
            }
            $subTotal = $ocupancy->occupPublishPrice;
            $boardBases = null;
            $supplements = null;
            if(isset($ocupancy->BoardBases->Boardbase)){
                $boardBases = $ocupancy->BoardBases->Boardbase;
            }
            if(isset($ocupancy->SelctedSupplements->Supplement)){
                $supplements = $ocupancy->SelctedSupplements->Supplement;
            }
            $supplementFeesArray = [
                "AtProperty"=>[],
                "Addition"=>[],
                "Included"=>[]
            ];
            $boardBasesArray = [];
            $additionalFees = 0;
            if(isset($supplements)){
                if(!is_array($supplements)){
                    $supplements = [$supplements];
                }
                foreach($supplements as $supplement){
                    if($supplement->suppChargeType=="AtProperty" && $supplement->suppIsMandatory){
                        $supplementFeesArray["AtProperty"][] = $supplement;
                    }elseif($supplement->suppChargeType=="Addition" && $supplement->suppIsMandatory){
                        $supplementFeesArray["Addition"][] = $supplement;
                    }elseif($supplement->suppChargeType=="Included" && $supplement->suppIsMandatory){
                        $supplementFeesArray["Included"][] = $supplement;
                    }
                }
            }
            if(isset($boardBases)){
                if(!is_array($boardBases)){
                 $boardBases = [$boardBases];
                }
                foreach($boardBases as $boardBase){
                    if($boardBase->bbPublishPrice == 0){
                        $boardBasesArray[] = $boardBase;
                    }
                }
            }
            
            foreach($supplementFeesArray["Addition"] as $addFee){
                $times = 1;
                if(get_class($supplement) == "App\PerPersonSupplement"){
                    $times = $package->numberOfPeople;
                }
                $additionalFees += $addFee->publishPrice * $times;
            }
            $activitiesFees = 0;
            foreach($activities as $activity){
                $activitiesFees += $activity->ActivityPricing->price;
            }
            $prices = [
                "retail"=> number_format(round($subTotal * (1 + $package->retailMarkupPercentage/100) + $additionalFees + $activitiesFees, 2),2),
                "trpz"=> number_format(round($subTotal * (1 + $package->trpzMarkupPercentage/100) + $additionalFees + $activitiesFees, 2),2),
                "jetSetGo"=> number_format(round($subTotal * (1 + $package->jetSetGoMarkupPercentage/100) + $additionalFees + $activitiesFees, 2),2),
                "price"=> $subTotal,
            ];
            return [
                'prices'=>$prices,
                'supplements'=>$supplementFeesArray,
                'boardBases'=>$boardBasesArray
            ];
        
    }
    private function getTouricoHotel($hotelId, $startDate, $endDate, $numberOfPeople){
        $hotel_api = new TouricoHotel();
            $data = [
                'request'=>[
                    'HotelIdsInfo'=>[
                        'HotelIdInfo'=>['id'=>$hotelId]
                    ],
                    'CheckIn'=>$startDate,
                    'CheckOut'=>$endDate,
                    'RoomsInformation'=>[
                        'RoomInfo'=>[
                            'AdultNum'=>$numberOfPeople,
                            'ChildNum'=>'0'
                        ]
                    ],
                    'MaxPrice'=>'0',
                    'StarLevel'=>'0',
                    'AvailableOnly'=>'true'
                ]
            ];
            $response = $hotel_api->SearchHotelsById($data);
            if(!isset($response->Hotel)){
                throw new Exception("This hotel is not available for the specified dates.");
            }
            return $response->Hotel;
    }
    public function getHotelById(){
        try{
            $hotelId=$this->request->query('hotel-id');
            $startDate = Carbon::parse($this->request->query('start-date'))->format('Y-m-d');
            $endDate = Carbon::parse($this->request->query('end-date'))->format('Y-m-d');
            $numberOfPeople = $this->request->query('number-of-people');
            $hotel = $this->getTouricoHotel($hotelId, $startDate, $endDate, $numberOfPeople);
            return response()->json(["success"=>true, "hotel"=>$hotel]);
        }catch(Exception $ex){
            return response()->json(["success"=>false, "message"=>$ex->getMessage()]);
        }
    }
    public function getHotelCancellationPolicy(){
        try{
            $roomTypeId = $this->request->query('roomType-id');
            $hotelId=$this->request->query('hotel-id');
            $startDate = Carbon::parse($this->request->query('start-date'))->format('Y-m-d');
            $endDate = Carbon::parse($this->request->query('end-date'))->format('Y-m-d');
            $hotel_api = new TouricoHotel();
            $data = [
                "nResId"=>0,
                "hotelId"=>$hotelId,
                "hotelRoomTypeId"=>$roomTypeId,
                "dtCheckIn"=>$startDate,
                "dtCheckOut"=>$endDate
            ];
            $hotelPolicy = $this->convertPolicyDataToMessage($hotel_api->GetCancellationPolicies($data));
            return response()->json(["success"=>true, "HotelPolicy"=>$hotelPolicy]);
        }catch(Exception $ex){
            return response()->json(["success"=>false, "message"=>$ex->getMessage()]);
        }
    }
    private function convertPolicyDataToMessage($policy) {
        $policyArray = $policy
                        ->HotelPolicy
                        ->RoomTypePolicy
                        ->CancelPolicy
                        ->CancelPenalty;

        // return $policyArray;
        $policyMessage = '';
        foreach($policyArray as $singlePolicy) {
           if ($singlePolicy->Deadline->OffsetUnitMultiplier == 0) {
               if ($singlePolicy->Deadline->OffsetDropTime == "AfterBooking") {
                  $policyMessage .= "At any point after booking";
              }
              if ($singlePolicy->Deadline->OffsetDropTime == "BeforeArrival") {
                    $policyMessage .= "For a \"No Show\"";
              }
               if ($singlePolicy->AmountPercent->BasisType == "FullStay") {
                   $policyMessage .= " the penalty is " . $singlePolicy->AmountPercent->Percent . "% of the cost for the full stay at this hotel.";
               }
               if ($singlePolicy->AmountPercent->BasisType == "Nights") {
                   $policyMessage .= " the penalty is the cost of " . $singlePolicy->AmountPercent->NmbrOfNights . " night(s) stay at this hotel.";
               }
           }

           if ($singlePolicy->Deadline->OffsetUnitMultiplier > 0) {
              if ($singlePolicy->Deadline->OffsetDropTime == "AfterBooking") {
                  $policyMessage .= "For cancellation " . $singlePolicy->Deadline->OffsetUnitMultiplier . " hour(s) after booking ";
              }
              if ($singlePolicy->Deadline->OffsetDropTime == "BeforeArrival") {
                    $policyMessage .= "For cancellation " . $singlePolicy->Deadline->OffsetUnitMultiplier . " hour(s) prior to arrival ";
              }
              if (property_exists($singlePolicy->AmountPercent, "NmbrOfNights")) {
                    $policyMessage .= "the cancellation penalty is " . $singlePolicy->AmountPercent->NmbrOfNights . " night(s) stay.";
              }
              if (property_exists($singlePolicy->AmountPercent, "Percent")) {
                    $policyMessage .= "the cancellation penalty is " . $singlePolicy->AmountPercent->Percent . "% of the total stay amount.";
              }
              if (property_exists($singlePolicy->AmountPercent, "Amount")) {
                    $policyMessage .= "the cancellation penalty is fixed at the amount of " . $singlePolicy->AmountPercent->Amount . " " . $singlePolicy->AmountPercent->CurrencyCode . ".";
              } 
           }
           $policyMessage .= "<br>";
        }

        return $policyMessage;
 }

    public function getActivityPrebook(){    
        try{            
            $activityId = $this->request->query('activityId');
            $date = Carbon::parse($this->request->query('date'))->format('Y-m-d');
            $optionId = $this->request->query('optionId')[0];
            $activity = Activity::find($activityId);
            $activityOption = ActivityOption::find($optionId);
            $data = [
                'BookActivityOptions'=>[
                    'bookActivityOptions'=>[
                      'PreBookOption'=>[
                        'ActivityId' => (string)($activity->activityId),
                        'Date' =>  (string)($date),
                        'OptionId' =>  (string)($activityOption->optionId),
                        'NumOfAdults'=>$activityOption->type == "PerPerson" ? $this->request->query('numberOfPeople') : '0',
                        'NumOfChildren'=>'0',
                        'NumOfUnits'=> $activityOption->type == "PerPerson" ? '0' : '1'
                      ]
                    ]
                ]
            ];
            $activity_api = new TouricoActivity;
            $response = $activity_api->ActivityPreBook($data);
            return response()->json(["success"=>true, "response"=>$response]);
        }catch(Exception $ex){
            return response()->json(["success"=>false, "message"=>$ex->getMessage()]);
        }
    }
}
