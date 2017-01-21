<div class="panel-body">
    <input type="hidden" ng-model="id" name="id"/>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Choose Categories</label>
                        <multiselect 
                            ng-model="selectedCategories" 
                            options="category.name for category in categories" 
                            data-multiple="true" 
                            data-compare-by="id"
                            name="selectedCategories"  
                            required></multiselect>
                        <span style="color:red" ng-show="selectedCategories.length < 1 && (packageForm.$submitted  || packageForm.selectedCategories.$touched )">
                            Select at least one Category.
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Package Name</label>
                        <input type="text" ng-model="name" name="name"  class="form-control" required>
                        <span style="color:red" ng-show="packageForm.name.$invalid && ( packageForm.$submitted  ||  packageForm.name.$touched )">
                            <span ng-show="packageForm.name.$error.required">Name is required.</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Number of Nights</label>
                        <input ng-model="numberOfNights" min="1" name="numberOfNights" type="number" class="form-control" required  ng-pattern="/^[0-9]+$/">
                        <span style="color:red" ng-show="packageForm.numberOfNights.$invalid &&  (packageForm.$submitted || packageForm.numberOfNights.$touched )">
                            <span ng-show="packageForm.numberOfNights.$error.required">Number of Nights required.</span>
                            <span ng-show="!packageForm.numberOfNights.$error.min && packageForm.numberOfNights.$error.pattern">Number of Nights must be integer.</span>
                            <span ng-show="packageForm.numberOfNights.$error.min">Number of Nights must be greater than zero.</span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input 
                            type="text" 
                            datetimepicker
                            datetimepicker-options="{format: 'MM/DD/YYYY'}"
                            ng-model="startDate" 
                            class="form-control"
                            name="startDate"
                            required
                            ng-change="nonFormValidation()"
                            >
                        <span style="color:red" ng-show="packageForm.startDate.$invalid && (packageForm.$submitted || packageForm.startDate.$touched)">
                            <span ng-show="packageForm.startDate.$error.required">Start Date required.</span>
                        </span>
                        <span style="color:red"><% startDateMessage %></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>End Date</label>
                        <input 
                            type="text" 
                            datetimepicker
                            datetimepicker-options="{format: 'MM/DD/YYYY'}"
                            ng-model="endDate" 
                            class="form-control"
                            name="endDate"
                            ng-change="nonFormValidation()"
                            required
                            >
                        <span style="color:red" ng-show="packageForm.endDate.$invalid && (packageForm.$submitted || packageForm.endDate.$touched)">
                            <span ng-show="packageForm.endDate.$error.required">End Date required.</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Number of People</label>
                        <input ng-model="numberOfPeople" min="1" name="numberOfPeople" ng-pattern="/^[0-9]+$/" type="number" class="form-control" required>
                        <span style="color:red" ng-show="packageForm.numberOfPeople.$invalid && (packageForm.$submitted || packageForm.numberOfPeople.$touched)">
                            <span ng-show="packageForm.numberOfPeople.$error.required">Number of People required.</span>
                            <span ng-show="!packageForm.numberOfPeople.$error.min && packageForm.numberOfPeople.$error.pattern">Number of People must be integer.</span>
                            <span ng-show="packageForm.numberOfPeople.$error.min">Number of People must be greater than zero.</span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Deal Ends</label>
                        <input 
                            type="text" 
                            style="text-transform:uppercase"
                            datetimepicker
                            datetimepicker-options="<% dealEndsOptions %>"
                            ng-model="dealEnd" 
                            class="form-control"
                            name="dealEnd"
                            ng-change="nonFormValidation()"
                            required>
                        <span style="color:red" ng-show=" packageForm.dealEnd.$invalid && (packageForm.$submitted || packageForm.dealEnd.$touched)">
                            <span ng-show="packageForm.dealEnd.$error.required">Deal Ends required.</span>
                        </span>
                        <span style="color:red"><% dealEndMessage %></span>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <label>Image</label>
             <input type="file" ngf-select ng-model="imgUpload" name="file" accept="image/*" ngf-max-size="2MB"  ng-required="!id" />
            <span style="color:red" ng-show="packageForm.file.$invalid && (packageForm.$submitted || packageForm.file.$touched)">
                <span ng-show="packageForm.file.$error.required">Image is required.</span>
            </span>
             <img ngf-thumbnail="imgUpload" class="thumb" ng-show="imgUpload" />
             <img src="{!! URL::to('/uploads/packages/'. (isset($package) ? $package->mainImage : '')) !!}" class="thumb" ng-show="id && !imgUpload"/>
        </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Amenities</label>
                    <text-angular name="amenities" ng-model="amenities"></text-angular>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Highlights</label>
                    <text-angular name="highlights" ng-model="highlights"></text-angular>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Fine Print</label>
                    <text-angular name="finePrint" ng-model="finePrint"></text-angular>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Trip Itinerary</label>
                    <text-angular name="tripItinerary" ng-model="tripItinerary"></text-angular>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Frequently Asked Questions</label>
                    <text-angular name="frequentlyAskedQuestions" ng-model="frequentlyAskedQuestions"></text-angular>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Other Notes</label>
                    <text-angular name="otherNotes" ng-model="otherNotes"></text-angular>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Retail Markup Percentage</label>
                <input ng-model="retailMarkupPercentage" name="retailMarkupPercentage" type="number" min="0" max="100" class="form-control" required>
                <span style="color:red" ng-show="packageForm.retailMarkupPercentage.$invalid && (packageForm.$submitted || packageForm.retailMarkupPercentage.$touched)">
                    <span ng-show="packageForm.retailMarkupPercentage.$error.required">Retail Markup Percentage required.</span>
                    <span ng-show="packageForm.retailMarkupPercentage.$error.min">Retail Markup Percentage must be greater or equal than 0.</span>
                    <span ng-show="packageForm.retailMarkupPercentage.$error.max">Retail Markup Percentage must be less or equal than 100.</span>
                </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>TRPZ Markup Percentage</label>
                <input ng-model="trpzMarkupPercentage" name="trpzMarkupPercentage" type="number" min="0" max="100" class="form-control" required>
                <span style="color:red" ng-show="packageForm.trpzMarkupPercentage.$invalid && (packageForm.$submitted || packageForm.trpzMarkupPercentage.$touched)">
                    <span ng-show="packageForm.trpzMarkupPercentage.$error.required">TRPZ Markup Percentage required.</span>
                    <span ng-show="packageForm.trpzMarkupPercentage.$error.min">TRPZ Markup Percentage must be greater or equal than 0.</span>
                    <span ng-show="packageForm.trpzMarkupPercentage.$error.max">TRPZ Markup Percentage must be less or equal than 100.</span>
                </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Jet Set Go Markup Percentage</label>
                <input ng-model="jetSetGoMarkupPercentage" name="jetSetGoMarkupPercentage" type="number" min="0" max="100" class="form-control" required>
                <span style="color:red" ng-show="packageForm.jetSetGoMarkupPercentage.$invalid && (packageForm.$submitted || packageForm.jetSetGoMarkupPercentage.$touched)">
                    <span ng-show="packageForm.jetSetGoMarkupPercentage.$error.required">Jet Set Go Markup Percentage required.</span>
                    <span ng-show="packageForm.jetSetGoMarkupPercentage.$error.min">Jet Set Go Markup Percentage must be greater or equal than 0.</span>
                    <span ng-show="packageForm.jetSetGoMarkupPercentage.$error.max">Jet Set Go Markup Percentage must be less or equal than 100.</span>
                </span>
            </div>
        </div>
        <div class="col-sm-6"></div>
        </div>
        <div class="row">
        <div class="col-sm-12">
            <h4 id="destination-text" class="pull-left">Select a Destination</h4>
        </div>
        </div>
        <div class="row">
        <div id="destination-menu" class="col-sm-12">
            <a
                ng-click="getDestinationByBreadcrumb(null, 0)">
                Continent 
            </a>
            &nbsp;>&nbsp;
            <span ng-repeat="segment in destinationSegments">
                <a ng-click="getDestinationByBreadcrumb(segment, $index)">
                    <%segment.name%>
                </a>
                &nbsp;>&nbsp;
            </span>
            <%city%>
        </div>
        </div>
        <div class="row">
        <div id="destination-menu" class="col-sm-2">
            <div 
                class="btn-group"
                uib-dropdown>
                <button
                    class="btn btn-default"
                    type="button"
                    uib-dropdown-toggle
                    ng-disabled="disabled">
                    <%destinationSegments.length ? 
                        destinationSegments[destinationSegments.length - 1].name : 
                        "Select Continent"%> 
                    <span class="caret"></span>
                </button>
                <ul
                    class="dropdown-menu"
                    id="destination-menu-list">
                    <li ng-repeat="destination in destinations">
                        <a ng-click="getDestinations(destination)">
                            <%destination.name%>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-sm-10"></div>
        </div>
        <div class="row">
        <div class="col-sm-12">
            <p ng-show="missingDates" class="alert alert-danger">Please choose valid start date and number of nights.</p>
        </div>
        </div>
        <div>
        <div class="row">
            <div class="col-sm-12">
                <h4>Select Hotel<img ng-show="hotelsLoading" class="loading" src="{{ url('img/trpzLoading.gif') }}"/></h4>
            </div>
        </div>
        <div class="row">
            <div id="added-hotels" class="col-sm-12">
                <p ng-repeat="hotel in addedHotels"><%hotel.name%>&nbsp;<span ng-click="removeHotel(hotel)" class="glyphicon glyphicon-remove"</p>
            </div>
            <span style="color:red" ng-show="packageForm.$submitted  && addedHotels.length < 1">Select a Hotel.</span>
        </div>
        <div class="row">
            <div id="hotels" class="col-sm-12">
                <!--<p ng-show="!hotels">Select a destination first.</p>
                <p ng-show="hotels && hotels.length === 0">No hotels available at this destination.</p>-->
                <div
                    ng-repeat="hotel in hotels"
                    class="hotel-panel panel panel-default pull-left"
                    ng-show="!hotelSelected || addedHotels[0] === hotel">
                    <div class="panel-heading">
                        <span ng-show="hotel.bestValue" class="glyphicon glyphicon-star" title="Exclusive Deal" style="color: #FFC107;"></span>
                        <%hotel.name%>
                        <div class="pull-right">
                            <span style="padding-right:25px"><%hotel.minAverPrice + ' ' + hotel.currency%></span>
                            <a  data-toggle="collapse" data-target="#hotel-<%$index%>"><span class="caret"></span> </a>
                        </div>
                    </div>
                    <div class="panel-body collapse" id="hotel-<%$index%>">
                        <div class="row">
                            <div class="col-sm-2">
                                <img width="100" height="100" src="<%hotel.thumb%>"/>
                            </div>
                            <div class="col-sm-10">
                                <%hotel.minAverPrice + ' ' + hotel.currency%><br>
                                <button ng-click="selectHotel(hotel);" class="select-hotel btn btn-default">Select</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p><%hotel.desc%></p>
                            </div>
                            <div class="col-sm-12"  ng-show="hotelSelected && addedHotels[0] === hotel && selectedHotelDetails">
                                <b>Location:</b> <% selectedHotelDetails.Location.address %>, <% selectedHotelDetails.Location.city %>, <% selectedHotelDetails.Location.state %> <% selectedHotelDetails.Location.zip %> 
                                <br/>
                                <b>Reference Points:</b> 
                                <ul>
                                    <li ng-repeat="refPoint in selectedHotelDetails.RefPoints">
                                        <% refPoint.distance %> <% refPoint.unit %>s <% refPoint.direction %> from <% refPoint.name %>
                                    </li>
                                </ul>
                                <br/>
                                <b>Amenities:</b>
                                <ul>
                                    <li ng-repeat="amenity in selectedHotelDetails.Amenities"><% amenity.name %></li>
                                </ul>
                                <br/>
                                <b>Room Types</b>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Room Type</th>
                                            <th>Facilities</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="roomType in selectedHotelDetails.RoomType">
                                            <td>
                                                <% roomType.name %>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li ng-repeat="facility in roomType.Facilities.Facility"><% facility.name %></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div>
        <div class="row">
            <div class="col-sm-12">
                <h4>Add Activities<img ng-show="activitiesLoading" class="loading" src="{{ url('img/trpzLoading.gif') }}"/></h4>
            </div>
        </div>
        <div class="row">
            <div id="added-activities" class="col-sm-12">
                <p ng-repeat="activity in addedActivities"><%activity.name%>&nbsp;<span ng-click="removeActivity(activity)" class="glyphicon glyphicon-remove"</p>
            </div>
            <!--<span style="color:red" ng-show="activityCategories.length > 0 && packageForm.$submitted && addedActivities.length < 1">Select at least one Activity.</span>-->
        </div>
        <div class="row">
            <div id="activityCategories" class="col-sm-12">
                <div ng-repeat="category in activityCategories">
                    <a ng-click="selectActivityCategory(category)"><%category.categoryName%></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="activities" class="col-sm-12">
                <div
                    ng-repeat="activity in activities"
                    class="activity-panel panel panel-default pull-left">
                     <div class="panel-heading"><%activity.name%></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <img width="100" height="100" src="<%activity.thumbURL%>"/>
                                <div style="margin:10px 0;">
                                    <button ng-click="addActivity(activity);" class="btn btn-default">Add to Package</button>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                City: <%activity.city%><br>
                                <span class="activity-options" ng-repeat="activityOption in activity.options">
                                    <%activityOption.name + '/' + activityOption.type%> -&nbsp;
                                    Adults: <%activityOption.availabilities[0].adultPrice%>&nbsp;<%activity.currency%>&nbsp;
                                    Child: <%activityOption.availabilities[0].childPrice%>&nbsp;<%activity.currency%>&nbsp;
                                    Unit: <%activityOption.availabilities[0].unitPrice%>&nbsp;<%activity.currency%>&nbsp;
                                <span><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p><%activity.description%></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel-footer">
    <div class="form-group">
        <input type="submit" ng-click="submit(imgUpload, packageForm)" class="btn btn-primary" value="Save"/>
        <a href="{!! route('packages.index') !!}" class="btn btn-default">Cancel</a>
    </div>
</div>

                            