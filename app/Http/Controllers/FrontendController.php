<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\Category;
use App\Hotel;
use App\Roomtype;
use App\Transaction;
use App\Purchase;
use App\PurchasePackage;
use App\PurchasePackageActivity;
use App\PurchasePackageActivityOption;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::all();
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
            return response("El hotel no fue encontrado.");
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
}
