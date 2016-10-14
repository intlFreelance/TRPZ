<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Purchase;

class PurchaseController extends Controller {
    
    /**
     * Display a list of Purchases.
     *
     * @return Response
     */
    public function index()
    {
        $purchases = Purchase::all();
        return view('admin.purchases.index')->with('purchases', $purchases);
    }
    /**
     * Display the specified Purchase.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $purchase = Purchase::find($id);

        if (empty($purchase)) {
            Session::flash('error','Purchase not found');
            return redirect(route('admin.purchases.index'));
        }

        return view('admin.purchases.show')->with('purchase', $purchase);
    }
}