@extends('layouts.app')

@section('content')
<link href="/css/create-package.css" rel="stylesheet">
<link href="/css/textAngular.css" rel="stylesheet">
<div class="container">
    <form  ng-controller="PackageController" name="packageForm" novalidate ng-init="loadModel({!! $package->id !!})">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Package</div>
                    <div class="panel-body">
                        @include('admin.packages.fields')
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" ng-click="submit(imgUpload, packageForm)" class="btn btn-primary" value="Save Package"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
