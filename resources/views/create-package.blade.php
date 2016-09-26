@extends('layouts.app')

@section('content')
<link href="/css/create-package.css" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Create a Package</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Package Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="package-image"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Number of Days</label>
                                <input type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" id="start-date" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="text" id="end-date" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 id="destination-text" class="pull-left">Select a Destination</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div id="destination-menu" class="col-sm-2">
                            <div class="dropdown">
                                <button 
                                    class="btn btn-default dropdown-toggle" 
                                    type="button" 
                                    id="destination-menu-title" 
                                    data-toggle="dropdown" 
                                    aria-haspopup="true" 
                                    aria-expanded="true"
                                    disabled="true">
                                </button>
                                <ul 
                                    class="dropdown-menu" 
                                    id="destination-menu-list">
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-10"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Add Hotels</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div id="added-hotels" class="col-sm-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p>
                                <button id="add-activity-button" class="btn btn-primary">Add Activity</button> 
                            </p>
                         </div>                       
                    </div>
                    <div class="row">
                        <div id="hotels" class="col-sm-12">
                            <p>Select a destination first.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var destinationId;
    var destinationCode;
    var hotels;
    var hotelIds = [];
    var activityId;
    var destinations = '{{ json_encode($destinations) }}';
    destinations = JSON.parse(destinations.replace(/&quot;/g,'"'));

</script>
<script type="text/javascript" src="{{ URL::asset('js/create-package.js') }}"></script>
@endsection
