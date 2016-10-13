@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Create New Customer</h2></div>
                    {!! Form::open(['route' => 'customers.store']) !!}
                        @include('admin.customers.fields')
                    {!! Form::close() !!}
            </div>
        </div>
    </div>
  </div>
@endsection
