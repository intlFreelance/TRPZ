@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Edit Customer</h2></div>
                    {!! Form::model($customer, ['route' => ['customers.update', $customer->id], 'method' => 'patch']) !!}
                        @include('admin.customers.fields')
                    {!! Form::close() !!}
            </div>
        </div>
    </div>
  </div>
@endsection
