@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12">
            <div>
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                      @if(Session::has($msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                      @endif
                    @endforeach
              </div>
                <h1 class="blue-header">Check Out</h1>
                {!! Form::open(['route' => ['payment'], 'method' => 'post']) !!}
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-6 form-group {{ $errors->has('paymentMethod') ? ' has-error' : '' }}">
                                <label>Payment Method</label>
                                {!! Form::select('paymentMethod', ['CC' => 'Credit Card', 'PayPal' => 'PayPal'], null, ['placeholder' => '', 'class'=>'form-control', 'id'=>'paymentMethod']); !!}
                            </div><div class="col-md-6"></div>
                        </div>
                            <div id="payPal-checkout">
                                <a href="https://paypal.com" target="_blank">
                                    <img src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-rect-paypalcheckout-60px.png" alt="PayPal Checkout">
                                </a>  
                            </div>
                            <div id="creditCard-checkout">
                                <div class="row">
                                    <div class="form-group col-md-12 {{ $errors->has('nameOnCard') ? ' has-error' : '' }}">
                                        <label>Name on card</label>
                                        {!! Form::text('nameOnCard', Auth::guard('customer')->user()->getFullName(), ['class' => 'form-control', 'required'=>'required']) !!}
                                        @if ($errors->has('nameOnCard'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('nameOnCard') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 {{ $errors->has('cardType') ? ' has-error' : '' }}" >
                                        <label>Card Type</label>
                                        {!! Form::select('cardType', ['VISA'=>'Visa', 'MC'=>'MasterCard'], null, ['placeholder'=>'', 'class'=>'form-control', 'required'=>'required']) !!}
                                        @if ($errors->has('cardType'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cardType') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-8 {{ $errors->has('cardNumber') ? ' has-error' : '' }}">
                                        <label>Card number</label>
                                        {!! Form::text('cardNumber', null, ['class' => 'form-control', 'required'=>'required']) !!}
                                        @if ($errors->has('cardNumber'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cardNumber') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 {{ $errors->has('expMonth') ? ' has-error' : '' }}">
                                        <label>Expiration Date</label>
                                        {!! Form::number('expMonth', null,  ['class' => 'form-control', 'required'=>'required', 'placeholder'=>'Month', 'step'=>1, 'min'=>1, 'max'=>12]) !!}
                                        @if ($errors->has('expMonth'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('expMonth') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4 {{ $errors->has('expYear') ? ' has-error' : '' }}">
                                        <label>&nbsp;</label>
                                        {!! Form::number('expYear', null,  ['class' => 'form-control', 'required'=>'required', 'placeholder'=>'Year', 'step'=>1, 'max'=>date('Y') + 10, 'min'=>date('Y')]) !!}
                                        @if ($errors->has('expYear'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('expYear') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4 {{ $errors->has('securityCode') ? ' has-error' : '' }}">
                                        <label>Security Code</label>
                                        {!! Form::text('securityCode', null,  ['class' => 'form-control', 'required'=>'required', 'step'=>1,'size'=>3, 'maxlength'=>3, 'pattern'=>'\d{3}']) !!}
                                        @if ($errors->has('securityCode'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('securityCode') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Billing Address</div>
                                            <?php $address = Auth::guard('customer')->user()->address ?>
                                            <div class="panel-body">
                                                <div class="row">
                                                     <div class="form-group col-sm-6 {{ $errors->has('address.line1') ? ' has-error' : '' }}">
                                                        {!! Form::label("address[line1]", 'Line 1:') !!}
                                                        {!! Form::text("address[line1]", $address['line1'],  ['class' => 'form-control', 'required'=>'required']) !!}
                                                        @if ($errors->has('address.line1'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('address.line1') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        {!! Form::label("address[line2]", 'Line 2:') !!}
                                                        {!! Form::text("address[line2]", $address['line2'],  ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-4">
                                                        {!! Form::label("address[city]", 'City:') !!}
                                                        {!! Form::text("address[city]", $address['city'],  ['class' => 'form-control', 'required'=>'required']) !!}
                                                        @if ($errors->has('address.city'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('address.city') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        {!! Form::label("address[state]", 'State:') !!}
                                                        {!! Form::text("address[state]", $address['state'],  ['class' => 'form-control', 'required'=>'required']) !!}
                                                        @if ($errors->has('address.state'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('address.state') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        {!! Form::label("address[zip]", 'Zip Code:') !!}
                                                        {!! Form::text("address[zip]", $address['zip'],  ['class' => 'form-control', 'required'=>'required']) !!}
                                                        @if ($errors->has('address.zip'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('address.zip') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-lg btn-success pull-right">Pay <i class="fa fa-credit-card" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-5 transaction-summary">
                        <h3>Transaction Summary</h3>
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>Package</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Cart::content() as $row)
                                    <tr>
                                        <td>
                                            <p><strong>{!! $row->name !!}</strong></p>
                                            <p>Start Date: {!! ($row->options->has('startDate') ? $row->options->startDate : '') !!}</p>
                                            <p>End Date: {!! ($row->options->has('endDate') ? $row->options->endDate : '') !!}</p>
                                        </td>
                                        <td class="text-right">${!! $row->price(2) !!}</td>
                                        <td class="text-right">${!! $row->total(2) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="1">&nbsp;</td>
                                    <td class="text-right">Subtotal</td>
                                    <td class="text-right">{!! Cart::subtotal(2) !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="1">&nbsp;</td>
                                    <td class="text-right">Total</td>
                                    <td class="text-right">{!! Cart::total(2) !!}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    @include('frontend.additional')    
</div>
<script>
$(function(){
    checkPaymentMethod();
    $("#paymentMethod").on("change", function(){
        checkPaymentMethod();
    });
    function checkPaymentMethod(){
        $("#payPal-checkout").hide();
        $("#creditCard-checkout").hide();
        var paymentMethod = $("#paymentMethod").val();
        if(paymentMethod==="CC"){
            $("#payPal-checkout").hide();
            $("#creditCard-checkout").show();
        }else if(paymentMethod==="PayPal"){
            $("#payPal-checkout").show();
            $("#creditCard-checkout").hide();
        }
    }
});
</script>
@endsection