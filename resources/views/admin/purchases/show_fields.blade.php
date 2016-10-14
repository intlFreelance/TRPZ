<div class="panel-body">
    <div class="row">
        <div class="form-group col-sm-2">
            {!! Form::label("transactionId", 'Transaction ID:') !!}
            {!! Form::text("transactionId", $purchase->transaction->transactionId,  ['class' => 'form-control', 'disabled'=>'disabled']) !!}
        </div>
        <div class="form-group col-sm-2">
            {!! Form::label("paymentMethod", 'Payment Method:') !!}
            {!! Form::text("paymentMethod", $purchase->transaction->paymentMethod,  ['class' => 'form-control', 'disabled'=>'disabled']) !!}
        </div>
        <div class="form-group col-sm-4">
            {!! Form::label("customerId", 'Customer Name:') !!}
            {!! Form::text("customerId", $purchase->transaction->customer->getFullName(),  ['class' => 'form-control', 'disabled'=>'disabled']) !!}
        </div>
        <div class="form-group col-sm-4">
            {!! Form::label("customerEmail", 'Customer Email:') !!}
            {!! Form::text("customerEmail", $purchase->transaction->customer->email,  ['class' => 'form-control', 'disabled'=>'disabled']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            {!! Form::label("packages", 'Packages:') !!}
            <ul>
                @foreach($purchase->purchasePackages as $purchasePackage)
                <li>
                        {!! App\Package::find($purchasePackage->packageId)->name !!}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="panel-footer">
    <div class="form-group">
        <a href="{!! route('purchases.index') !!}" class="btn btn-default">Back</a>
    </div>
</div>