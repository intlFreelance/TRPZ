@extends('layouts.frontend')

@section('content')
    <div class="container-fluid">
       <div class="row">
            <div class="col-md-12 category-container category-container-image" 
             style="background-image: url( {!! url('uploads/packages/'.$package->mainImage) !!} )">
                    <div class="package-container-title-left"> 
                        <h4>{!! $category->name !!}</h4>
                        <h3>{!! $package->name !!}</h3> 
                    </div>
            </div>    
        </div>
        <div class="row package-pricing">
                <div class="package-price col-md-4">
                    <p>Retail Price: $ {!! number_format($package->retailPrice,2) !!}</p>
                </div>
                <div class="package-price col-md-4">
                    <p>Jet Set Go Price: $ {!! number_format($package->jetSetGoPrice,2) !!}</p>
                </div>
                <div class="package-price col-md-4">
                    <p>Trpz Price: $ {!! number_format($package->trpzPrice,2) !!}</p>
                </div>
           
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 package-deal-ends">
                            <p>Deal Ends:</p>
                            <p id="dealEnds"></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 package-learn-more">
                        <a href="#">
                                <p>Learn More</p>
                        </a>
                    </div>
                </div>
                
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div id="package-map"></div>
                </div>
            </div>
         
        </div>
        <div class="package-descriptions row">
            <?php
                if(!empty($package->amenities)){
                    echo "<div class='container package-description'><h3>Amenities</h3>{$package->amenities}</div>";
                }
                if(!empty($package->highlights)){
                    echo "<div class='container package-description'><h3>Highlights</h3>{$package->highlights}</div>";
                }
                if(!empty($package->finePrint)){
                    echo "<div class='container package-description'><h3>Fine Print</h3>{$package->finePrint}</div>";
                }
                if(!empty($package->tripItinerary)){
                    echo "<div class='container package-description'><h3>Trip Itinerary</h3>{$package->tripItinerary}</div>";
                }
                if(!empty($package->frequentlyAskedQuestions)){
                    echo "<div class='container package-description'><h3>Frequently Asked Questions</h3>{$package->frequentlyAskedQuestions}</div>";
                }
                if(!empty($package->otherNotes)){
                    echo "<div class='container package-description'><h3>Other Notes</h3>{$package->otherNotes}</div>";
                }
            ?>
        </div>
        @if(!$noinputs)
        <div class="row">
            {!! Form::open(['route' => ['cart.add'], 'method' => 'post']) !!}
            <input type="hidden" value="{!! $package->id !!}" name="packageId" />
            <input type="hidden" value="{!! $package->numberOfDays !!}" id="numberOfDays"/>
            <div class="container">
                <div class="col-md-6">
                    <div class="col-md-12"><h3>Select Dates</h3></div>
                    <div class="col-md-6 form-group {!! $errors->has('startDate') ? 'has-error' : '' !!}">
                        <label for="startDate" class="control-label">Start Date</label>
                        @if(isset($voucher))
                            {!! Form::text('startDate', $package->startDate->format('m/d/Y'), [ 'class' => 'form-control', 'readonly'=>'readonly']) !!}
                        @else
                            {!! Form::text('startDate', null, ['id'=>'startDate', 'class' => 'form-control', 'required'=>'required']) !!}
                            @if ($errors->has('startDate'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('startDate') }}</strong>
                                </span>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="endDate" class="control-label">End Date</label>
                        @if(isset($voucher))
                            {!! Form::text('endDate', $package->startDate->addDays($package->numberOfDays)->format('m/d/Y'), [ 'class' => 'form-control', 'readonly'=>'readonly']) !!}
                        @else
                            {!! Form::text('endDate', null, ['id'=>'endDate', 'class' => 'form-control', 'required'=>'required', 'readonly'=>'readonly']) !!}
                        @endif
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12"><h3>Package Options</h3></div>
                </div>
            </div>
            <div class="container">
                <div class="col-md-6 form-group">
                    <h3>Hotel</h3>
                     <?php $hotel = $package->packageHotels[0]->hotel; ?>
                    <div class="panel panel-default">
                       <div class="panel-heading">{!! $hotel->name !!}</div>
                       <div class="panel-body">
                           <div class="row">
                               <div class="col-md-3">
                                   <img src="{!! $hotel->thumb !!}" />
                               </div>
                               <div class="col-md-9">
                                   <p >{!! $hotel->description !!}</p>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-12">
                                   <p >{!! $hotel->address !!}</p>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
                <div class="col-md-6 form-group">
                    <h3>Room Type</h3>
                    @if(isset($voucher))
                        {!! Form::text('roomTypeId', !isset($hotel->hotelRoomtypes[0]) ? "" : $hotel->hotelRoomtypes[0]->roomtype->name, [ 'class' => 'form-control', 'readonly'=>'readonly']) !!}
                    @else
                     {!! Form::select('roomTypeId', 
                            DB::table('roomTypes')->join('hotel_roomtypes', 'roomTypes.id', '=', 'hotel_roomtypes.roomtypeId')->where('hotel_roomtypes.hotel_id', '=' , $hotel->id)->pluck('roomTypes.name', 'roomTypes.id') , 
                            null, 
                            ['placeholder' => '', 'class'=>'form-control']
                        ); 
                     !!}
                    @endif
                </div>
            </div>
            <div class="container">
                <div class="col-md-6 form-group pad30">
                    <h3>Activities</h3>
                     @if(!isset($voucher))
                    <select class="form-control" class="activityId" id="activityId" name="activityIds[]" multiple="multiple">
                        @foreach($package->packageActivities as $packageActivity)
                            <?php $activity = App\Activity::find($packageActivity->activityId); ?>
                        <option value="{!! $activity->id !!}"> {!! $activity->name !!}</option>
                        @endforeach
                    </select>
                     @endif
                </div>
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-12 activities">
                    @foreach($package->packageActivities as $key => $packageActivity)
                        <?php $activity = App\Activity::find($packageActivity->activityId); ?>
                    <div class="col-md-4 {!! !(isset($voucher) && $key <= 2) ? 'activity-item' : ''!!}" id="activity-{!! $activity->id !!}">
                            <div class="panel panel-default">
                                <div class="panel-heading">{!! $activity->name !!}</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <img src="{!! $activity->thumbURL !!}"/>
                                        </div>
                                        <div class="col-xs-8">
                                            <p>{!! $activity->description !!}</p>
                                        </div>
                                        
                                        <div class="col-xs-12">
                                            <label>Options</label>
                                            @if(isset($voucher))
                                            <p>{!! $activity->activityOptions[0]->name !!}</p> 
                                            @else
                                                <select class="form-control activity-options" name="activityOptions[{!! $activity->id !!}][]" id="activityOptions_{!! $activity->id !!}" multiple="multiple">
                                                    @foreach($activity->activityOptions as $option)
                                                    <option value="{!! $option->id !!}"> {!! $option->name !!}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                        
            </div>
            @endif
            @if(!$nonav)
            <div class="container">
                <div class="col-md-12 pad30"><h3>Package Pricing Options</h3></div>
                <div class="col-md-6">
                    <div class="package-pricing2">
                        <div class="package-pricing2-description">
                            <div class="col-md-6">
                                <h4>Jet Set Go®</h4>
                                <h4>$ {!! number_format($package->jetSetGoPrice,2) !!}</h4>
                                <p>Discount: 61% </p>
                            </div>
                            <div class="col-md-6">
                                <p style="font-size: 14px;">Jet Set Go® offers you a whole new way pay for travel: by playing games! Download Jet Set Go® right now to stop paying for travel and start playing for travel!</p>
                            </div>
                        </div>
                        <input id="start-playing" class="button package-buttons" type="submit" name="jetSet" value="Start Playing!"/>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="package-pricing2">
                        <div class="package-pricing2-description">
                            <div class="col-md-6">
                                <h4>Trpz™</h4>
                                <h4>$ {!! number_format($package->trpzPrice,2) !!}</h4>
                                <p>Discount: 39%</p>
                            </div>
                            <div class="col-md-6">
                                <p style="font-size: 14px;">By booking your vacation package with Trpz™, you receive unmatched discounts on one of a kind vacation experiences.</p>
                            </div>
                        </div>
                        <input type="submit" class="button package-buttons" id="book-now" name="trpz" value="Book Now" />
                    </div>
                </div>
            </div>
            @endif
            {!! Form::close() !!}
        </div>
        @if(!$nonav)
            @include('frontend.additional')    
        @endif
    </div>



 <script>
$(function(){
    var now = moment(new Date());
    var end = moment("{!! $package->dealEndDate !!}");
    var duration = moment.duration(end.diff(now));
    if(duration.minutes() >= 0){
        var dealEnds = duration.days() + " days, " + duration.hours() + " hours and " + duration.minutes() + " minutes";
    }else{
        var dealEnds = "expired";
    }
    $("#dealEnds").html(dealEnds);
    $("#startDate").datetimepicker({
        format: 'MM/DD/YYYY',
        minDate: moment("{!! $package->startDate !!}"),
        maxDate: moment("{!! $package->endDate !!}")
    }).on("dp.hide", function (e) {
        var endDate = new Date(e.date);
        var numberOfDays = parseInt($("#numberOfDays").val());
        endDate.setDate(endDate.getDate() + numberOfDays);
        $('#endDate').val(moment(endDate).format('MM/DD/YYYY'));
    }).val("");
    $("#hotelId").on("change", function(){
        $("#roomTypeId").empty().append('<option value></option>');
        $("#hotel-panel").hide();
        $("#hotel-name").html("");
        $("#hotel-thumb").attr("src", "");
        $("#hotel-description").html("");
        $("#hotel-address").html("");
        var hotelId = $(this).val();
        if(hotelId=="") return;
        $.get("/hotel/"+hotelId, function(data){
            var roomTypes = data.roomTypes;
            var hotel = data.hotel;
            $.each(roomTypes, function(i, roomType){
                $("#roomTypeId").append('<option value="'+ roomType.id +'">'+ roomType.name +'</option>');
            });
            $("#hotel-panel").show();
            $("#hotel-name").html(hotel.name);
            $("#hotel-thumb").attr("src", hotel.thumb);
            $("#hotel-description").html(hotel.description);
            $("#hotel-address").html(hotel.address);
        });
    });
    $("#activityId").multiselect({
        buttonWidth: '100%',
        onChange: function(option, checked, select) {
            var activityId = $(option).val();
            if(checked){
                $("#activity-"+activityId).show();
            }else{
                $('#activityOptions_'+activityId).multiselect('deselectAll', false);
                $('#activityOptions_'+activityId).multiselect('updateButtonText');
                $("#activity-"+activityId).hide();
            }
        }
    });
    $(".activity-options").multiselect({buttonWidth: '100%'});
});
function initMap() {
    var map = new google.maps.Map(document.getElementById('package-map'), {
      scrollwheel: false,
      zoom: 15
    });
@foreach($package->packageHotels as $key => $packageHotel)
<?php $hotel = App\Hotel::find($packageHotel->hotelId); ?>
    var hotelLocation{!!$key!!} = {lat: {!! $hotel->latitude !!}, lng: {!! $hotel->longitude !!}};
    var marker{!!$key!!} = new google.maps.Marker({
       map: map,
       position: hotelLocation{!!$key!!},
       title: '{!! $hotel->name !!}'
     });
@endforeach
  map.setCenter(hotelLocation0);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDB05Vggn0A3-DwI7AwGWEe2ea5E5K1ZYs&callback=initMap" async defer></script>
@endsection