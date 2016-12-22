@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12">
                <h1 class="blue-header">Purchase Confirmation</h1>
                <h3>Transaction Code: {!! $purchase->transaction->transactionId !!} </h3>
                @foreach($booking as $b)
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Package {!! $b->package->name !!}</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            @if($b->success)
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">{!! $b->hotel->name !!} - Hotel Reservation #{!! $b->hotelBooking->Reservations->Reservation->reservationId !!}</h3></div>
                                    <div class="panel-body">
                                        <p><b>Address:</b> {!! $b->hotel->Location->address !!}, {!! $b->hotel->Location->city !!}, {!! $b->hotel->Location->stateCode !!}</p>
                                        <p><b>Number of Room:</b> {!! $b->hotel->NumOfRoom !!}</p>
                                        <p><b>Number of People:</b> {!! $b->hotelBooking->Reservations->Reservation->numOfAdults !!}</p>
                                        <p><b>CheckIn Date:</b> {!!  \Carbon\Carbon::parse($b->hotelBooking->Reservations->Reservation->fromDate)->format('d/m/Y') !!}</p>
                                        <p><b>CheckOut Date:</b> {!!  \Carbon\Carbon::parse($b->hotelBooking->Reservations->Reservation->toDate)->format('d/m/Y') !!}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    @if(count($b->activitiesBooking) > 0)
                                        <h3>Activities</h3>
                                        @foreach($b->activitiesBooking as $ab)
                                            <div class="col-sm-6">
                                                @if($ab->success)
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><h3 class="panel-title">Activity Reservation #{!! $ab->hotelBooking->Reservations->Reservation->reservationId !!}</h3></div>
                                                        <div class="panel-body">
                                                            
                                                        </div>
                                                    </div>
                                                @else
                                                    <p>We're sorry, there was an error while booking the Activity.</p>
                                                    <p>{!! $ab->message !!}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                <div class="col-sm-12">
                                    <p>We're sorry, there was an error while booking the Hotel.</p>
                                    <p>{!! $b->message !!}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                    {!! dump($b) !!}
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    @include('frontend.additional')    
</div>
@endsection