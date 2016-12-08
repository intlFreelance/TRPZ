<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use Session;

class CustomerController extends Controller
{
    /**
     * Display a list of Customers.
     *
     * @return Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index')->with('customers', $customers);
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created Customer in storage.
     *
     * @param Customer $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'email' => 'required|email|max:255',
            'address.line1' => 'required',
            'address.city' => 'required',
            'address.state' => 'required',
            'address.zip' => 'required',
            'password'=>'required|min:6|confirmed'
        ]);
        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        Customer::create($input);
        
        Session::flash('success','Customer saved successfully.');
        return redirect(route('customers.index'));
    }

    /**
     * Display the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (empty($customer)) {
            Session::flash('error','Customer not found');
            return redirect(route('admin.customers.index'));
        }

        return view('admin.customers.show')->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        if (empty($customer)) {
            Session::flash('error','Customer not found');

            return redirect(route('admin.customers.index'));
        }
        return view('admin.customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param  int              $id
     * @param Customer $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $customer = Customer::find($id);

        if (empty($customer)) {
          Session::flash('error','Customer not found');

          return redirect(route('customers.index'));
        }
        
         $this->validate($request, [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'email' => 'required|email|max:255',
            'address.line1' => 'required',
            'address.city' => 'required',
            'address.state' => 'required',
            'address.zip' => 'required',
            'password'=>'min:6|confirmed'
        ]);
         
        $input = $request->all();
        if(empty($input["password"])){
            unset($input["password"]);
        }else{
            $input["password"] = bcrypt($input["password"]);
        }

        Customer::find($id)->update($input);

        Session::flash('success','Customer updated successfully.');

        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (empty($customer)) {
          Session::flash('error','Customer not found');

          return redirect(route('customers.index'));
        }

        Customer::find($id)->delete();

        Session::flash('success','Customer deleted successfully.');

        return redirect(route('customers.index'));
    }
}