@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12">
                <h1 class="blue-header">Purchase Confirmation</h1>
                <h3>Confirmation Code: #56789098 </h3>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Package</th>
                            <th>Hotel</th>
                            <th>Room Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Activities</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase->purchasePackages as $key => $purchasePackage)
                            <tr>
                                <td>{!! $key + 1 !!}</td>
                                <td><strong>{!! $purchasePackage->package->name !!}</strong></td>
                                <td> {!! $purchasePackage->hotel->name !!} </td>
                                <td>{!! $purchasePackage->roomType->name !!}</td>
                                <td>{!! $purchasePackage->startDate->format('m/d/Y') !!}</td>
                                <td>{!! $purchasePackage->endDate->format('m/d/Y') !!}</td>
                                <td>
                                    <ul>
                                        @foreach($purchasePackage->purchasePackageActivities as $purchasePackageActivity)
                                            <li>{!! $purchasePackageActivity->activity->name !!}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    @include('frontend.additional')    
</div>
@endsection