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
        <div class="row">
            <div class="container">
                <div class="col-md-6">
                    <div class="col-md-12"><h3>Select Dates</h3></div>
                    <div class="col-md-6 form-group">
                        <label>Start Date</label>
                        <input type="text" class="form-control" id="startDate"/>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>End Date</label>
                        <input type="text" class="form-control" id="endDate"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12"><h3>Package Options</h3></div>
                </div>
            </div>
            <div class="container">
                <div class="col-md-6">
                    <div class="col-md-12 form-group">
                        <h3>Room Type</h3>
                        <select class="form-control"></select>
                    </div>

                </div>
            </div>
            <div class="container">
                <div class="col-md-12 form-group">
                    <h3>Activity Type</h3>
                    <ul>
                        @foreach($package->packageActivities as $packageActivity)
                            <?php $activity = App\Activity::find($packageActivity->activityId); ?>
                        <li><img src="{!! $activity->thumbURL !!}" class="activity-image"/> {!! $activity->name !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="col-md-12"><h3>Package Pricing Options</h3></div>
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
                        <a href="#" class="button package-buttons" id="start-playing">Start Playing!</a>
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

                        <a href="#" id="book-now" class="button package-buttons">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
        @include('frontend.additional')    
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
    }).on("dp.change", function (e) {
        $('#endDate').data("DateTimePicker").minDate(e.date);
    });;
    $("#endDate").datetimepicker({
        format: 'MM/DD/YYYY',
        minDate: moment("{!! $package->startDate !!}"),
        maxDate: moment("{!! $package->endDate !!}")
    }).on("dp.change", function (e) {
            $('#startDate').data("DateTimePicker").maxDate(e.date);
    });;
     
        
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