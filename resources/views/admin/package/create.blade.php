@extends('layouts.app')

@section('content')
<link href="/css/create-package.css" rel="stylesheet">
<link href="/css/textAngular.css" rel="stylesheet">
<div class="container">
    <form  ng-controller="PackageController" name="myForm" novalidate>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a Package</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Choose Category</label>
                                            <select ng-model="categoryId" name="categoryId" class="form-control">   
                                                <option value>Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            <span style="color:red" ng-show="myForm.categoryId.$invalid && (myForm.$submitted  || myForm.categoryId.$touched )">
                                                <span ng-show="myForm.name.$error.required">Category is required.</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Package Name</label>
                                            <input type="text" ng-model="name" name="name"  class="form-control" required>
                                            <span style="color:red" ng-show="myForm.name.$invalid && ( myForm.$submitted  ||  myForm.name.$touched )">
                                                <span ng-show="myForm.name.$error.required">Name is required.</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Number of Days</label>
                                            <input ng-model="numberOfDays" min="1" name="numberOfDays" type="number" class="form-control" required  ng-pattern="/^[0-9]+$/">
                                            <span style="color:red" ng-show="myForm.numberOfDays.$invalid &&  (myForm.$submitted || myForm.numberOfDays.$touched )">
                                                <span ng-show="myForm.numberOfDays.$error.required">Number of Days required.</span>
                                                <span ng-show="!myForm.numberOfDays.$error.min && myForm.numberOfDays.$error.pattern">Number of Days must be integer.</span>
                                                <span ng-show="myForm.numberOfDays.$error.min">Number of People must be greater than zero.</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input 
                                                type="text" 
                                                uib-datepicker-popup="MM/dd/yyyy"
                                                is-open="dateStart.open" 
                                                ng-focus="dateStart.open=true" 
                                                ng-model="startDate" 
                                                class="form-control"
                                                name="startDate"
                                                required
                                                ng-change="extraValidation()"
                                                >
                                            <span style="color:red" ng-show="myForm.startDate.$invalid && (myForm.$submitted || myForm.startDate.$touched)">
                                                <span ng-show="myForm.startDate.$error.required">Start Date required.</span>
                                            </span>
                                            <span style="color:red"><% startDateMessage %></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input 
                                                type="text" 
                                                uib-datepicker-popup="MM/dd/yyyy"
                                                is-open="dateEnd.open" 
                                                ng-focus="dateEnd.open=true" 
                                                ng-model="endDate" 
                                                class="form-control"
                                                name="endDate"
                                                ng-change="extraValidation()"
                                                required
                                                >
                                            <span style="color:red" ng-show="myForm.endDate.$invalid && (myForm.$submitted || myForm.endDate.$touched)">
                                                <span ng-show="myForm.endDate.$error.required">End Date required.</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Number of People</label>
                                            <input ng-model="numberOfPeople" min="1" name="numberOfPeople" ng-pattern="/^[0-9]+$/" type="number" class="form-control" required>
                                            <span style="color:red" ng-show="myForm.numberOfPeople.$invalid && (myForm.$submitted || myForm.numberOfPeople.$touched)">
                                                <span ng-show="myForm.numberOfPeople.$error.required">Number of People required.</span>
                                                <span ng-show="!myForm.numberOfPeople.$error.min && myForm.numberOfPeople.$error.pattern">Number of People must be integer.</span>
                                                <span ng-show="myForm.numberOfPeople.$error.min">Number of People must be greater than zero.</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Deal Ends</label>
                                            <input 
                                                type="text" 
                                                uib-datepicker-popup="MM/dd/yyyy hh:mm a"
                                                is-open="dealEnd.open" 
                                                ng-focus="dealEnd.open=true" 
                                                ng-model="dealEnd" 
                                                class="form-control"
                                                name="dealEnd"
                                                ng-change="extraValidation()"
                                                required>
                                            <span style="color:red" ng-show=" myForm.dealEnd.$invalid && (myForm.$submitted || myForm.dealEnd.$touched)">
                                                <span ng-show="myForm.dealEnd.$error.required">Deal Ends required.</span>
                                            </span>
                                            <span style="color:red"><% dealEndMessage %></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Image</label>
                                 <input type="file" ngf-select ng-model="imgUpload" name="file"    
                                accept="image/*" ngf-max-size="2MB" required>
                                <span style="color:red" ng-show="myForm.file.$invalid && (myForm.$submitted || myForm.file.$touched)">
                                    <span ng-show="myForm.file.$error.required">Image is required.</span>
                                </span>
                                 <img ngf-thumbnail="imgUpload" class="thumb"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <text-angular name="description" ng-model="description" required></text-angular>
                                    <span style="color:red" ng-show="myForm.description.$invalid && (myForm.$submitted || myForm.description.$touched)">
                                        <span ng-show="myForm.description.$error.required">Description is required.</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Retail Price</label>
                                    <input ng-model="retailPrice" name="retailPrice" type="number" class="form-control" required>
                                    <span style="color:red" ng-show="myForm.retailPrice.$invalid && (myForm.$submitted || myForm.retailPrice.$touched)">
                                        <span ng-show="myForm.retailPrice.$error.required">Retail Price required.</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>TRPZ Price</label>
                                    <input ng-model="trpzPrice" name="trpzPrice" type="number" class="form-control" required>
                                    <span style="color:red" ng-show="myForm.trpzPrice.$invalid && (myForm.$submitted || myForm.trpzPrice.$touched)">
                                        <span ng-show="myForm.trpzPrice.$error.required">TRPZ Price required.</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Jet Set Go Price</label>
                                    <input ng-model="jetSetGoPrice" name="jetSetGoPrice" type="number" class="form-control" required>
                                    <span style="color:red" ng-show="myForm.jetSetGoPrice.$invalid && (myForm.$submitted || myForm.jetSetGoPrice.$touched)">
                                        <span ng-show="myForm.jetSetGoPrice.$error.required">Jet Set Go Price required.</span>
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
                                <p ng-show="missingDates" class="alert alert-danger">Please Choose valid start and end dates</p>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>Add Hotels<img ng-show="activitiesLoading" class="loading" src="{{ url('img/trpzLoading.gif') }}"/></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div id="added-hotels" class="col-sm-12">
                                    <p ng-repeat="hotel in addedHotels"><%hotel.name%>&nbsp;<span ng-click="removeHotel(hotel)" class="glyphicon glyphicon-remove"</p>
                                </div>
                                <span style="color:red" ng-show="myForm.$submitted  && addedHotels.length < 1">Select at least one Hotel.</span>
                            </div>
                            <div class="row">
                                <div id="hotels" class="col-sm-12">
                                    <!--<p ng-show="!hotels">Select a destination first.</p>
                                    <p ng-show="hotels && hotels.length === 0">No hotels available at this destination.</p>-->
                                    <div
                                        ng-repeat="hotel in hotels"
                                        class="hotel-panel panel panel-default pull-left">
                                        <div class="panel-heading"><%hotel.name%></div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <img width="100" height:"100" src="<%hotel.thumb%>"/>
                                                </div>
                                                <div class="col-sm-10">
                                                    <%hotel.minAverPrice + ' ' + hotel.currency%><br>
                                                    <button ng-click="addHotel(hotel);" class="select-hotel btn btn-default">Add to Package</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p><%hotel.desc%></p>
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
                                <span style="color:red" ng-show="myForm.$submitted && addedActivities.length < 1">Select at least one Activity.</span>
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
                                                    <img width="100" height:"100" src="<%activity.thumbURL%>"/>
                                                </div>
                                                <div class="col-sm-10">
                                                    Adult: <%activity.ActivityOptions.ActivityOption.Availabilities.Availability.adultPrice%>&nbsp;<%activity.currency%><br>
                                                    Child: <%activity.ActivityOptions.ActivityOption.Availabilities.Availability.childPrice%>&nbsp;<%activity.currency%><br>
                                                    <span ng-if="isArray(activity.ActivityOptions.ActivityOption)">
                                                        Unit: <%activity.ActivityOptions.ActivityOption[0].Availabilities.Availability.unitPrice%>&nbsp;<%activity.currency%><br>
                                                    </span>
                                                    <button ng-click="addActivity(activity);" class="btn btn-default">Add to Package</button>
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
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" ng-click="submit(imgUpload, myForm)" class="btn btn-primary" value="Create Package"
                                      />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
