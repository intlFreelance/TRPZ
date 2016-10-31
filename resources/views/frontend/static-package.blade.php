@if($nonav)
<!DOCTYPE html>
<html lang="en" ng-app="frontend">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="qLbzudXmmRHJwCRFduWHyrcByC0yabPxWmDRvZGp">

    <title>TRPZ</title>

    <!-- Styles -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="/css/frontend.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    <!-- Scripts -->
    <script>
        window.Laravel = {"csrfToken":"qLbzudXmmRHJwCRFduWHyrcByC0yabPxWmDRvZGp"}    </script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
        <div id="full-page-cover"></div>
    <div id="full-page">
      <div class="container-full blue-container"> 
          <nav class="navbar main-navbar" role="navigation">
              <div class="container-fluid">
                <div class="navbar-header">
                                          <a class="navbar-brand" href="#"><img src="http://trpz.wpengine.com/wp-content/themes/TRPZ/images/TRPZ-logo.png"/></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                      
                </div>
              </div>
          </nav>      
        </div>
          
      </div>
          <div class="container-fluid">
       <div class="row">
            <div class="col-md-12 category-container category-container-image" 
             style="background-image: url( http://trpz.wpengine.com/wp-content/uploads/2016/08/hotsprings.png )">
                    <div class="package-container-title-left"> 
                        <h4>High-Energy Excitement</h4>
                        <h3>Fabulous Las Vegas</h3> 
                    </div>
            </div>    
        </div>
        <div class="row package-pricing">
                <div class="package-price col-md-4">
                    <p>Retail Price: $ 5,499.99</p>
                </div>
                <div class="package-price col-md-4">
                    <p>Jet Set Go Price: $ 4,999.99</p>
                </div>
                <div class="package-price col-md-4">
                    <p>Trpz Price: $ 5,199.99</p>
                </div>
           
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 package-deal-ends-nonav" >
                            <p>Deal Ends:</p>
                            <p id="dealEnds"></p>
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
            <div class='container package-description'><h3>Highlights</h3><p>At the heart of the Las Vegas is the four-mile (six-kilometer) stretch of Las Vegas Boulevard affectionately dubbed &#34;The Strip&#34; Hotels and casinos began cropping up here in the mid-1940s. The Flamingo was among the first, opened by mobster Bugsy Siegel in 1946 and named for his leggy girlfriend, whose nickname was Flamingo. The Strip was made popular as a location in countless Hollywood films, and is known today for its five-star casino resorts, decedent day-spas and pools,  and glamorous nightlife. <br/></p></div><div class='container package-description'><h3>Other Notes</h3><p>If you think Las Vegas is stuck in the middle of nowhere, think again. There’s Red Rock Canyon to the west, Hoover Dam and the Grand Canyon to the east and the rugged beauty of the Mojave Desert to the south. From Las Vegas there are a variety of day tours to all these locations. Experience the southwest whatever way you want, whether on horseback or behind the wheel of an ATV.<br/></p></div>        </div>
                    <div class="container">
                <div class="col-md-12 form-group">
                    <h3>Hotel</h3>
                                         <div class="panel panel-default">
                       <div class="panel-heading">Westin Lake Las Vegas Resort - Demo</div>
                       <div class="panel-body">
                           <div class="row">
                               <div class="col-md-3">
                                   <img src="http://image1.urlforimages.com/Images/1211762/100x100/85530231.jpg" />
                               </div>
                               <div class="col-md-9">
                                   <p >Demo - Location
This hotel is located on the shores of Lake Las Vegas. The nearest town of Henderson is about 3 km away and offers numerous shops and entertainment venues. It is about 25 km to the lively centre of Las Vegas, with Las Vegas airport some 3</p>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-12">
                                   <p >Demo - 101 MonteLago Boulevard Henderson Nevada 89011</p>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
                            </div>
            
            <div class="container">
                <div class="col-md-6 form-group pad30">
                    <h3>Activities</h3>
                                     </div>
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-12 activities">
                                                                <div class="col-md-4 " id="activity-101">
                            <div class="panel panel-default">
                                <div class="panel-heading">Grand Canyon Explorer Tour - Demo</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <img src="http://image1.urlforimages.com/1239114/Airplane4_Thumbnailed.jpg"/>
                                        </div>
                                        <div class="col-xs-8">
                                            <p>Demo - Experience the adventure of a lifetime with a flight to the Grand Canyon!</p>
                                        </div>
                                        
                                        <div class="col-xs-12">
                                            <label>Options</label>
                                                                                        <p>10:00am Tour</p> 
                                                                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                                                                <div class="col-md-4 " id="activity-100">
                            <div class="panel panel-default">
                                <div class="panel-heading">Las Vegas Night Tour - Demo</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <img src="http://image1.urlforimages.com/1297218/LVNight-3_Thumb.jpg"/>
                                        </div>
                                        <div class="col-xs-8">
                                            <p>Demo - As dusk falls, the city comes to life illuminated by the dazzling neon lights Las Vegas is famous for.</p>
                                        </div>
                                        
                                        <div class="col-xs-12">
                                            <label>Options</label>
                                                                                        <p>Panoramic Night Tour Ticket</p> 
                                                                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                                                                <div class="col-md-4 " id="activity-99">
                            <div class="panel panel-default">
                                <div class="panel-heading">Champagne Night Strip Tour - Demo</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <img src="http://image1.urlforimages.com/1323569/LasVegasWelcomeSign_Thumbnailed.jpg"/>
                                        </div>
                                        <div class="col-xs-8">
                                            <p>Demo - Enjoy the evening just like a rock star as you experience the Amazing Las Vegas Strip.</p>
                                        </div>
                                        
                                        <div class="col-xs-12">
                                            <label>Options</label>
                                                                                        <p>Tour Ticket</p> 
                                                                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                                    </div>
                        
            </div>
            
                        </form>
        </div>
            </div>



 <script>
$(function(){
    var now = moment(new Date());
    var end = moment("2016-11-30 20:36:00");
    var duration = moment.duration(end.diff(now));
    if(duration.minutes() >= 0){
        var dealEnds = duration.days() + " days, " + duration.hours() + " hours and " + duration.minutes() + " minutes";
    }else{
        var dealEnds = "expired";
    }
    $("#dealEnds").html(dealEnds);
    $("#startDate").datetimepicker({
        format: 'MM/DD/YYYY',
        minDate: moment("12/01/2016"),
        maxDate: moment("12/31/2016")
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
    var hotelLocation0 = {lat: 36.11392415, lng: -114.92314840};
    var marker0 = new google.maps.Marker({
       map: map,
       position: hotelLocation0,
       title: 'Westin Lake Las Vegas Resort - Demo'
     });
  map.setCenter(hotelLocation0);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDB05Vggn0A3-DwI7AwGWEe2ea5E5K1ZYs&callback=initMap" async defer></script>
      <div class="container-full blue-container footer">
        <div class="container">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"><img src="http://trpz.wpengine.com/wp-content/themes/TRPZ/images/TRPZ-logo.png"/></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Scripts -->
    <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="/js/frontend.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
</body>
</html>
@else

<!DOCTYPE html>
<html lang="en" ng-app="frontend">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="qLbzudXmmRHJwCRFduWHyrcByC0yabPxWmDRvZGp">

    <title>TRPZ</title>

    <!-- Styles -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="/css/frontend.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    <!-- Scripts -->
    <script>
        window.Laravel = {"csrfToken":"qLbzudXmmRHJwCRFduWHyrcByC0yabPxWmDRvZGp"}    </script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
        <div id="full-page-cover"></div>
    <div id="full-page">
      <div class="container-full blue-container"> 
          <nav class="navbar main-navbar" role="navigation">
              <div class="container-fluid">
                <div class="navbar-header">
                                          <a class="navbar-brand" href="#"><img src="http://trpz.wpengine.com/wp-content/themes/TRPZ/images/TRPZ-logo.png"/></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                      
                </div>
              </div>
          </nav>      
        </div>
          
      </div>
          <div class="container-fluid">
       <div class="row">
            <div class="col-md-12 category-container category-container-image" 
             style="background-image: url( http://trpz.wpengine.com/wp-content/uploads/2016/08/hotsprings.png )">
                    <div class="package-container-title-left"> 
                        <h4>High-Energy Excitement</h4>
                        <h3>Fabulous Las Vegas</h3> 
                    </div>
            </div>    
        </div>
        <div class="row package-pricing">
                <div class="package-price col-md-4">
                    <p>Retail Price: $ 5,499.99</p>
                </div>
                <div class="package-price col-md-4">
                    <p>Jet Set Go Price: $ 4,999.99</p>
                </div>
                <div class="package-price col-md-4">
                    <p>Trpz Price: $ 5,199.99</p>
                </div>
           
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 package-deal-ends-nonav" >
                            <p>Deal Ends:</p>
                            <p id="dealEnds"></p>
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
            <div class='container package-description'><h3>Highlights</h3><p>At the heart of the Las Vegas is the four-mile (six-kilometer) stretch of Las Vegas Boulevard affectionately dubbed &#34;The Strip&#34; Hotels and casinos began cropping up here in the mid-1940s. The Flamingo was among the first, opened by mobster Bugsy Siegel in 1946 and named for his leggy girlfriend, whose nickname was Flamingo. The Strip was made popular as a location in countless Hollywood films, and is known today for its five-star casino resorts, decedent day-spas and pools,  and glamorous nightlife. <br/></p></div><div class='container package-description'><h3>Other Notes</h3><p>If you think Las Vegas is stuck in the middle of nowhere, think again. There’s Red Rock Canyon to the west, Hoover Dam and the Grand Canyon to the east and the rugged beauty of the Mojave Desert to the south. From Las Vegas there are a variety of day tours to all these locations. Experience the southwest whatever way you want, whether on horseback or behind the wheel of an ATV.<br/></p></div>        </div>
                <div class="row">
            <form method="POST" action="http://localhost:8000/cart" accept-charset="UTF-8"><input name="_token" type="hidden" value="qLbzudXmmRHJwCRFduWHyrcByC0yabPxWmDRvZGp">
            <input type="hidden" value="76" name="packageId" />
            <input type="hidden" value="5" id="numberOfDays"/>
            <div class="container">
                <div class="col-md-6">
                    <div class="col-md-12"><h3>Select Dates</h3></div>
                    <div class="col-md-6 form-group ">
                        <label for="startDate" class="control-label">Start Date</label>
                                                    <input class="form-control" readonly="readonly" name="startDate" type="text" value="12/01/2016">
                                            </div>
                    <div class="col-md-6 form-group">
                        <label for="endDate" class="control-label">End Date</label>
                                                    <input class="form-control" readonly="readonly" name="endDate" type="text" value="12/06/2016">
                                                
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12"><h3>Package Options</h3></div>
                </div>
            </div>
                        <div class="container">
                <div class="col-md-6 form-group">
                    <h3>Hotel</h3>
                                         <div class="panel panel-default">
                       <div class="panel-heading">Westin Lake Las Vegas Resort - Demo</div>
                       <div class="panel-body">
                           <div class="row">
                               <div class="col-md-3">
                                   <img src="http://image1.urlforimages.com/Images/1211762/100x100/85530231.jpg" />
                               </div>
                               <div class="col-md-9">
                                   <p >Demo - Location
This hotel is located on the shores of Lake Las Vegas. The nearest town of Henderson is about 3 km away and offers numerous shops and entertainment venues. It is about 25 km to the lively centre of Las Vegas, with Las Vegas airport some 3</p>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-12">
                                   <p >Demo - 101 MonteLago Boulevard Henderson Nevada 89011</p>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
                                <div class="col-md-6 form-group">
                    <h3>Room Type</h3>
                                            <input class="form-control" readonly="readonly" name="roomTypeId" type="text" value="Standard">
                                    </div>
                            </div>
            
            <div class="container">
                <div class="col-md-6 form-group pad30">
                    <h3>Activities</h3>
                                     </div>
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-12 activities">
                                                                <div class="col-md-4 " id="activity-101">
                            <div class="panel panel-default">
                                <div class="panel-heading">Grand Canyon Explorer Tour - Demo</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <img src="http://image1.urlforimages.com/1239114/Airplane4_Thumbnailed.jpg"/>
                                        </div>
                                        <div class="col-xs-8">
                                            <p>Demo - Experience the adventure of a lifetime with a flight to the Grand Canyon!</p>
                                        </div>
                                        
                                        <div class="col-xs-12">
                                            <label>Options</label>
                                                                                        <p>10:00am Tour</p> 
                                                                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                                                                <div class="col-md-4 " id="activity-100">
                            <div class="panel panel-default">
                                <div class="panel-heading">Las Vegas Night Tour - Demo</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <img src="http://image1.urlforimages.com/1297218/LVNight-3_Thumb.jpg"/>
                                        </div>
                                        <div class="col-xs-8">
                                            <p>Demo - As dusk falls, the city comes to life illuminated by the dazzling neon lights Las Vegas is famous for.</p>
                                        </div>
                                        
                                        <div class="col-xs-12">
                                            <label>Options</label>
                                                                                        <p>Panoramic Night Tour Ticket</p> 
                                                                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                                                                <div class="col-md-4 " id="activity-99">
                            <div class="panel panel-default">
                                <div class="panel-heading">Champagne Night Strip Tour - Demo</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <img src="http://image1.urlforimages.com/1323569/LasVegasWelcomeSign_Thumbnailed.jpg"/>
                                        </div>
                                        <div class="col-xs-8">
                                            <p>Demo - Enjoy the evening just like a rock star as you experience the Amazing Las Vegas Strip.</p>
                                        </div>
                                        
                                        <div class="col-xs-12">
                                            <label>Options</label>
                                                                                        <p>Tour Ticket</p> 
                                                                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                                    </div>
                        
            </div>
            
                        </form>
        </div>
            </div>



 <script>
$(function(){
    var now = moment(new Date());
    var end = moment("2016-11-30 20:36:00");
    var duration = moment.duration(end.diff(now));
    if(duration.minutes() >= 0){
        var dealEnds = duration.days() + " days, " + duration.hours() + " hours and " + duration.minutes() + " minutes";
    }else{
        var dealEnds = "expired";
    }
    $("#dealEnds").html(dealEnds);
    $("#startDate").datetimepicker({
        format: 'MM/DD/YYYY',
        minDate: moment("2016-12-01 00:00:00"),
        maxDate: moment("2016-12-31 00:00:00")
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
    var hotelLocation0 = {lat: 36.11392415, lng: -114.92314840};
    var marker0 = new google.maps.Marker({
       map: map,
       position: hotelLocation0,
       title: 'Westin Lake Las Vegas Resort - Demo'
     });
  map.setCenter(hotelLocation0);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDB05Vggn0A3-DwI7AwGWEe2ea5E5K1ZYs&callback=initMap" async defer></script>
      <div class="container-full blue-container footer">
        <div class="container">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"><img src="http://trpz.wpengine.com/wp-content/themes/TRPZ/images/TRPZ-logo.png"/></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Scripts -->
    <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="/js/frontend.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
</body>
</html>


@endif
