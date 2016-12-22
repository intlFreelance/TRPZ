@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12">
                <h1 class="blue-header">Purchase Confirmation</h1>
                <h3>Purchase Confirmation Code: {!! $purchase->transaction->transactionId !!} </h3>
                @foreach($booking as $b)
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title">Package {!! $b->package->name !!}</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            @if($b->success)
                            <div class="col-md-12">
                                <h3>Hotel</h3>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title">{!! $b->hotel->name !!} - Hotel Reservation #{!! $b->hotelBooking->Reservations->Reservation->reservationId !!}</h3></div>
                                    <div class="panel-body">
                                        <p><b>Address:</b> {!! $b->hotel->Location->address !!}, {!! $b->hotel->Location->city !!}, {!! $b->hotel->Location->stateCode !!}</p>
                                        <p><b>Number of People:</b> {!! $b->hotelBooking->Reservations->Reservation->numOfAdults !!}</p>
                                        <p><b>CheckIn Date:</b> {!!  \Carbon\Carbon::parse($b->hotelBooking->Reservations->Reservation->fromDate)->format('d/m/Y') !!}</p>
                                        <p><b>CheckOut Date:</b> {!!  \Carbon\Carbon::parse($b->hotelBooking->Reservations->Reservation->toDate)->format('d/m/Y') !!}</p>
                                        <p><b>Voucher Code:</b> {!! $b->hotelBooking->tranNum !!}</p>
                                    </div>
                                </div>
                            </div>
                                <div class="col-sm-12">
                                    @if(count($b->activitiesBooking) > 0)
                                        <h3>Activities</h3>
                                        <?php $count = count($b->activitiesBooking);  ?>
                                        @foreach($b->activitiesBooking as $key => $ab)
                                        @if($key % 2 == 0)
                                            <div class="row">
                                        @endif
                                            <?php $activity =  App\Activity::find($ab->activity->activityDbId); ?>
                                            <div class="col-sm-6">
                                                @if($ab->success)
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><h3 class="panel-title">{!! $activity->name !!} - Activity Reservation #{!! $ab->activityBooking->Reservations->ActivityReservation->reservationId !!}</h3></div>
                                                        <div class="panel-body">
                                                            <p><b>Activity Date:</b>{!! \Carbon\Carbon::parse($ab->activityBooking->Reservations->ActivityReservation->date)->format('d/m/Y') !!}</p>
                                                            <p><b>Voucher Code:</b> {!! $ab->activityBooking->Reservations->ActivityReservation->tranNumber !!}</p>
                                                            <p><b>Description:</b> {!! $activity->description !!}</p>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"><h3 class="panel-title">{!! $activity->name !!} - Activity Reservation</h3></div>
                                                        <div class="panel-body">
                                                            <p>We're sorry, there was an error while booking the Activity.</p>
                                                            <p>{!! $ab->message !!}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @if($key % 2 != 0 || $key+1 == $count)
                                            </div>
                                        @endif
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
                @endforeach
            </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p class="pull-right">
                            <h3>Total Charged: ${!! number_format($purchase->transaction->amount, 2)  !!}</h3>
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <a href="javascript: window.print();" class="btn btn-lg btn-warning pull-right no-print"><i class="fa fa-print" aria-hidden="true"></i> Print Purchase Confirmation</a>
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="container-fluid no-print">
    @include('frontend.additional')    
</div>
@endsection