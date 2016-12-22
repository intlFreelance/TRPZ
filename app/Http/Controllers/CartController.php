<?php

namespace App\Http\Controllers;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Package;
use App\Activity;
use App\ActivityOption;

use Session;

class CartController extends Controller{
    public function index(){
        //Cart::destroy();
         //dd(Cart::content());
        return view('frontend.cart');
    }
    public function destroy($rowId){
        Cart::remove($rowId);
        Session::flash('success','Cart item successfully deleted.');
        return redirect(route('cart.index'));
    }
    public function add(Request $request){
        $this->validate($request, [
            'startDate' => 'required',
            'endDate' => 'required',
            'roomTypeId'=>'required'
        ]);
        $input = $request->all();
        foreach(Cart::content() as $row){
            if($row->id == $input['packageId']){
                Session::flash('danger','The package selected already exists in cart.');
                return redirect()->back();
            }
        }
        $package = Package::find($input['packageId']);
        
        $price = floatval(str_replace(",","",$input[$input['priceType']]));
        $activities = [];
        if(isset($input['activities'])){
            foreach($input['activities'] as $activity){
                $activities[] = json_decode(html_entity_decode($activity, ENT_QUOTES | ENT_HTML5));
            }
        }
        $supplements = [];
        if(isset($input["supplements"])){
            foreach($input["supplements"] as $sup){
                $supplements[] = json_decode($sup);
            }
        }
        $boardBases = [];
        if(isset($input["boardBases"])){
            foreach($input["boardBases"] as $bb){
                $boardBases[] = json_decode($bb);
            }
        }
        $hotel = json_decode($input['hotel']);
        Cart::add($package->id, $package->name, 1, $price, 
        [
            'startDate'         => $input['startDate'], 
            'endDate'           => $input['endDate'],
            'hotel'             => $hotel,
            'roomTypeId'        => $input['roomTypeId'],
            'activities'        => $activities,
            'boardBases'        => $boardBases,
            'supplements'       => $supplements,
            'priceType'         => $input['priceType'],
        ])->setTaxRate(0);
        return redirect(route('cart.index'));
    }
}