<?php

namespace App\Http\Controllers;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Package;
use Session;

class CartController extends Controller{
    public function index(){
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
        ]);
        $input = $request->all();
        foreach(Cart::content() as $row){
            if($row->id == $input['packageId']){
                Session::flash('danger','The package selected already exists in cart.');
                return redirect()->back();
            }
        }
        $package = Package::find($input['packageId']);
        $price = $package->retailPrice;
        if(isset($input["jetSet"])){
            $price = $package->jetSetGoPrice;
        }else if(isset($input["trpz"])){
            $price = $package->trpzPrice;
        }
        
        Cart::add($package->id, $package->name, 1, $price, 
        [
            'startDate' =>  $input['startDate'], 
            'endDate'=>     $input['endDate']
        ])->setTaxRate(0);
        return redirect(route('cart.index'));
    }
}