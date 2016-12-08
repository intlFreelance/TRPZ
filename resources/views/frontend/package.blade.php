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
                    <p>Retail Price: <span id="retailPrice" class="text-muted">Select Travel Dates</span></p>
                </div>
                <div class="package-price col-md-4">
                    <p>Jet Set Go Price: <span id="jetSetGoPrice" class="text-muted">Select Travel Dates</span></p>
                </div>
                <div class="package-price col-md-4">
                    <p>Trpz Price: <span id="trpzPrice" class="text-muted">Select Travel Dates</span></p>
                </div>
           
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 {!! $nonav ? 'package-deal-ends-nonav' : 'package-deal-ends' !!}" >
                            <p>Deal Ends:</p>
                            <p id="dealEnds"></p>
                    </div>
                </div>
                @if(!$nonav)
                <div class="row">
                    <div class="col-md-12 package-learn-more">
                        <a href="#">
                                <p>Learn More</p>
                        </a>
                    </div>
                </div>
                @endif
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
            {!! Form::open(['route' => ['cart.add'], 'method' => 'post', 'id'=>'package-form']) !!}
            <input type="hidden" value="{!! $package->id !!}" name="packageId" id="packageId"/>
            <input type="hidden" value="{!! $package->numberOfDays !!}" id="numberOfDays"/>
            <input type="hidden" id="priceType" name="priceType"/>
            <input type="hidden" id="trpz" name="trpz"/>
            <input type="hidden" id="jetSetGo" name="jetSetGo"/>
            <input type="hidden" id="retail" name="retail"/>
            <div class="container">
                <div class="col-md-6">
                    <h3>Select Dates</h3>
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
                    <h3>Package Options</h3>
                </div>
            </div>
            @endif
            <div class="container">
                <div class="col-md-{!! $noinputs ? '12' : '6' !!} form-group">
                    <h3>Hotel</h3>
                     <?php $hotel = $package->packageHotels[0]->hotel; ?>
                    {!! Form::hidden('hotel-id', $hotel->hotelId, ["id"=>"hotel-id"]) !!}
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
                @if(!$noinputs)
                <div class="col-md-6 form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Room Type</h3>
                            <select id="roomTypeId" name="roomTypeId" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="divAdditionalFees" style="display: none">
                            <h3>Additional</h3>
                            <table id="tbladditionalFees" class="table table-striped table-responsive">
                                <thead>
                                    <th>Name</th><th>Price</th><th>Pay Type</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <ul id="ulBoardBases"></ul>
                            <div id="divBoardBases"></div>
                        </div>
                    </div>
                        
                    
                    
                </div>
                @endif
            </div>
            
            <div class="container">
                <div class="col-md-6 form-group">
                    <h3>Activities</h3>
                     @if(!$nonav)
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
                    <div class="col-md-4 {!! !($nonav && $key <= 2) ? 'activity-item' : ''!!}" id="activity-{!! $activity->id !!}">
                            <div class="panel panel-default">
                                <div class="panel-heading">{!! $activity->name !!}</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{!! $activity->thumbURL !!}"/>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{!! $activity->description !!}</p>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label>Options</label>
                                            @if($nonav)
                                            <p>{!! $activity->activityOptions[0]->name !!}</p> 
                                            @else
                                                <select class="form-control activity-options" name="activityOptions[{!! $activity->id !!}][]" id="activityOptions_{!! $activity->id !!}">
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
            
            @if(!$nonav)
            <div class="container">
                <div class="col-md-12"><h3>Package Pricing Options</h3></div>
                <div class="col-md-6">
                    <div class="package-pricing2">
                        <div class="package-pricing2-description">
                            <div class="col-md-6">
                                <h4>Jet Set Go®</h4>
                                <h4 id="jetSetGoPrice2" class="text-muted">Select Travel Dates</h4>
                                <p>Discount: 61% </p>
                            </div>
                            <div class="col-md-6">
                                <p style="font-size: 14px;">Jet Set Go® offers you a whole new way pay for travel: by playing games! Download Jet Set Go® right now to stop paying for travel and start playing for travel!</p>
                            </div>
                        </div>
                        <input type="button" id="start-playing" class="button package-buttons"   value="Start Playing!" onclick="checkCancellationPolicy('jetSetGo');"/>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="package-pricing2">
                        <div class="package-pricing2-description">
                            <div class="col-md-6">
                                <h4>Trpz™</h4>
                                <h4 id="trpzPrice2" class="text-muted">Select Travel Dates</h4>
                                <p>Discount: 39%</p>
                            </div>
                            <div class="col-md-6">
                                <p style="font-size: 14px;">By booking your vacation package with Trpz™, you receive unmatched discounts on one of a kind vacation experiences.</p>
                            </div>
                        </div>
                        <input type="button" id="book-now" class="button package-buttons"  value="Book Now" onclick="checkCancellationPolicy('trpz');" />
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
<div class="modal fade" id="policy-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hotel Cancellation Policy</h4>
      </div>
      <div class="modal-body">
          <div id="divCancellationPolicy"></div>
      </div>
      <div class="modal-footer">
          <button type="button" id="btnAcceptPolicy" class="btn btn-primary">I Accept</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">I do not Accept</button>
      </div>
    </div>
  </div>
</div>
 <script>
var roomTypes;
var roomType;
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
        loadHotelInfo();
    }).val("");
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
    $("#roomTypeId").on("change", function(){
        loadPrices();
    });
    $("#btnAcceptPolicy").click(function(){
        $("#package-form").submit();
    });
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
function loadHotelInfo(){
    var data = {
        'hotel-id' : $('#hotel-id').val(),
        'start-date' : $('#startDate').val(),
        'end-date' : $('#endDate').val()
    };
    $.get("/search-hotel-by-id", data, function(data){
        if(!data.success){
            alert(data.message);
            return;
        }
        var hotel = data.hotel;
        roomTypes = hotel.RoomTypes.RoomType;
        console.log(hotel);
        if(Array.isArray(roomTypes)){
            $("#roomTypeId").empty().append("<option value></option>");
            roomTypes.forEach(function(roomType, i){
                $("#roomTypeId").append("<option value='"+roomType.hotelRoomTypeId+"'>"+roomType.name+"</option>");
            });
        }else{
            $("#roomTypeId").empty().append("<option value></option>");
            $("#roomTypeId").append("<option value='"+roomTypes.hotelRoomTypeId+"'>"+roomTypes.name+"</option>");
        }
    });
}
function loadPrices(){
    if($("#roomTypeId").val() == "") return;
    var data = {
        'hotel-id' : $('#hotel-id').val(),
        'start-date' : $('#startDate').val(),
        'end-date' : $('#endDate').val(),
        'roomType-id' : $('#roomTypeId').val(),
        'package-id' : $("#packageId").val()
    };
    $.get("/get-hotel-price", data, function(data){
        if(!data.success){
            alert(data.message);
            return;
        }
        $("#retailPrice").html("$ "+data.prices.retail).removeClass("text-muted");
        $("#retail").val(data.prices.retail);
        $("#trpzPrice").html("$ "+data.prices.trpz).removeClass("text-muted");
        $("#trpzPrice2").html("$ "+data.prices.trpz).removeClass("text-muted");
        $("#trpz").val(data.prices.trpz);
        $("#jetSetGoPrice").html("$ "+data.prices.jetSetGo).removeClass("text-muted");
        $("#jetSetGoPrice2").html("$ "+data.prices.jetSetGo).removeClass("text-muted");
        $("#jetSetGo").val(data.prices.jetSetGo);
        if(data.supplements.AtProperty.length > 0 || data.supplements.Addition.length > 0 || data.boardBases.length > 0){ 
            $("#divAdditionalFees").show();
            if(data.supplements.AtProperty.lenght > 0 || data.supplements.Addition.lenght > 0){
                $("#tbladditionalFees").show();
            }else{
                $("#tbladditionalFees").hide();
            }
        }else{
            $("#divAdditionalFees").hide();
        }
        
        $("#tbladditionalFees tbody").empty();
        data.supplements.AtProperty.forEach(function(sup, i){
            $("#tbladditionalFees tbody").append("<tr><td>"+sup.suppName+"</td><td>"+sup.publishPrice+"</td><td>At Property</td></tr>");
        });
        data.supplements.Addition.forEach(function(sup, i){
            $("#tbladditionalFees tbody").append("<tr><td>"+sup.suppName+"</td><td>"+sup.publishPrice+"</td><td>Included in price</td></tr>");
        });
         $("#ulBoardBases").empty();
         $("#divBoardBases").empty();
        data.boardBases.forEach(function(bb, i){
            $("#ulBoardBases").append("<li id='"+bb.bbId+"'>"+bb.bbName+" is included</li>");
            $("#divBoardBases").append("<input type='hidden' name='boardBases[]' value='"+bb.bbId+"'>");
        });
    });
}
function checkCancellationPolicy(button){
    var formValid = $("#package-form")[0].checkValidity();
    if(!formValid){
        alert("Please select Travel Dates and Room Type");
        return;
    }
    $("#priceType").val(button);
    var data = {
        'hotel-id' : $('#hotel-id').val(),
        'start-date' : $('#startDate').val(),
        'end-date' : $('#endDate').val(),
        'roomType-id' : $('#roomTypeId').val()
    };
    $.get("/get-hotel-cancellation-policy", data, function(data){
        $("#divCancellationPolicy").html(JSON.stringify(data));
        $("#policy-modal").modal();
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDB05Vggn0A3-DwI7AwGWEe2ea5E5K1ZYs&callback=initMap" async defer></script>
@endsection