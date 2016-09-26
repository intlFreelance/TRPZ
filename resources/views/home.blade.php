@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    <ul>
                    <li><a href="{{ url('packages/create') }}">Create Package</a></li>
                      <li><a href="{{ url('activities') }}">Activities Test</a></li>
                      <li><a href="{{ url('hotels') }}">Hotels Test</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
