@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Create New Category</h1>
        </div>
    </div>

    <div class="row">
        {!! Form::open(['route' => 'categories.store']) !!}

            @include('admin.categories.fields')

        {!! Form::close() !!}
    </div>
  </div>
@endsection
