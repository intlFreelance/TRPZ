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
        $data['category'] = Category::find($categoryId);
        $data['package'] = \App\Package::find($id);
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
        return view('frontend.payment');
    }
    public function makePayment(Request $request){
        $this->validate($request, [
            'paymentMethod' => 'required|max:255',
            'nameOnCard' => 'required|max:255',
            'cardNumber' => 'required|max:16|min:16',
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
        
        //Purchase details
        foreach(Cart::content() as $row){
            $purchasePackage = new PurchasePackage;
            $purchasePackage->packageId = $row->id;
            $purchasePackage->purchase_id = $purchase->id;
            $purchasePackage->startDate = Carbon::parse($row->options->startDate)->format('Y-m-d');
            $purchasePackage->endDate = Carbon::parse($row->options->endDate)->format('Y-m-d');
            $purchasePackage->hotelId = $row->options->hotelId;
            $purchasePackage->roomTypeId = $row->options->roomTypeId;
            $purchasePackage->save();
            foreach($row->options->activities as $activity){
                $purchasePackageActivity = new PurchasePackageActivity;
                $purchasePackageActivity->activityId = $activity['id'];
                $purchasePackageActivity->purchase_package_id = $purchasePackage->id;
                $purchasePackageActivity->save();
                foreach($activity["options"] as $optionId){
                    $purchasePackageActivityOption = new PurchasePackageActivityOption;
                    $purchasePackageActivityOption->activity_optionId = $optionId;
                    $purchasePackageActivityOption->purchase_package_activity_id = $purchasePackageActivity->id;
                    $purchasePackageActivityOption->save();
                }
            }
        }
        
        //Destroy Shopping Cart
        Cart::destroy();
        $data['purchase'] = $purchase;
        return view('frontend.confirmation', $data);
    }
    
    public function confirmation($id){
        $purchase = Purchase:: find($id);
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
            $hotel = $this->getTouricoHotel($hotelId, $startDate, $endDate);
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
            $subTotal = 0;
            
            if(is_array($roomType->Occupancies->Occupancy)){
                $ocupancy = $roomType->Occupancies->Occupancy[0];
            }else{
                $ocupancy = $roomType->Occupancies->Occupancy;
            }
            $breakdownPrices = $ocupancy->PriceBreakdown->Price;
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
                "Addition"=>[]
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
            foreach($breakdownPrices as $price){
                $subTotal += floatval($price->valuePublish);
            }
            foreach($supplementFeesArray["Addition"] as $addFee){
                $times = 1;
                if(get_class($supplement) == "App\PerPersonSupplement"){
                    $times = $package->numberOfPeople;
                }
                $additionalFees += $addFee->publishPrice * $times;
            }
            
            $prices = [
                "retail"=> number_format(round($subTotal * (1 + $package->retailMarkupPercentage/100) + $additionalFees, 2),2),
                "trpz"=> number_format(round($subTotal * (1 + $package->trpzMarkupPercentage/100) + $additionalFees, 2),2),
                "jetSetGo"=> number_format(round($subTotal * (1 + $package->jetSetGoMarkupPercentage/100) + $additionalFees, 2),2)
            ];
            return response()->json(['success'=>true, 'prices'=>$prices, 'supplements'=>$supplementFeesArray, 'boardBases'=>$boardBasesArray]);
        }catch(Exception $ex){
            throw $ex;
            return response()->json(["success"=>false, "message"=>$ex->getMessage()]);
        }
    }
    private function getTouricoHotel($hotelId, $startDate, $endDate){
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
                            'AdultNum'=>'2',
                            'ChildNum'=>'0'
                        ]
                    ],
                    'MaxPrice'=>'0',
                    'StarLevel'=>'0',
                    'AvailableOnly'=>'false'
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
            $hotel = $this->getTouricoHotel($hotelId, $startDate, $endDate);
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
               if ($singlePolicy->AmountPercent->BasisType == "FullStay") {
                   $policyMessage .= "After the cancellation deadline, the penalty is " . $singlePolicy->AmountPercent->Percent . "% of the cost for the full stay at this hotel.";
               }
               if ($singlePolicy->AmountPercent->BasisType == "Nights") {
                   $policyMessage .= "After the cancellation deadline, the penalty is the cost of " . $singlePolicy->AmountPercent->NmbrOfNights . " night(s) stay at this hotel.";
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
            $optionId = $this->request->query('optionId');
            $activity = Activity::find($activityId);
            $activityOption = ActivityOption::find($optionId);
            $data = [
                'BookActivityOptions'=>[
                    'bookActivityOptions'=>[
                      'PreBookOption'=>[
                        'ActivityId' => (string)($activity->activityId),
                        'Date' =>  (string)($date),
                        'OptionId' =>  (string)($activityOption->optionId),
                        'NumOfAdults'=>$this->request->query('numberOfPeople'),
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
