<table class="table table-responsive table-striped" id="categories-table">
    <thead>
        <th>Transaction ID</th>
        <th>Payment Method</th>
        <th>Customer Name</th>
        <th>Customer Email</th>
        <th>Packages</th>
        <th colspan="3" class="text-right">Action</th>
    </thead>
    <tbody>
    @foreach($purchases as $purchase)
        <tr>
            <td>{!! $purchase->transaction->transactionId !!}</td>
            <td>{!! $purchase->transaction->paymentMethod !!}</td>
            <td>
                <a href="{!! route('customers.show', [$purchase->transaction->customer->id]) !!}">
                    {!! $purchase->transaction->customer->getFullName() !!}
                </a>
            </td>
            <td>{!! $purchase->transaction->customer->email !!}</td>
            <td>
                <ul>
                    @foreach($purchase->purchasePackages as $purchasePackage)
                    <li>
                            {!! App\Package::find($purchasePackage->packageId)->name !!}
                    </li>
                    @endforeach
                </ul>
            </td>
            <td class="text-right">
                <div class='btn-group'>
                    <a href="{!! route('purchases.show', [$purchase->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
