@extends('layouts.app')

@section('content')
  <div class="container">
        <h1 class="pull-left">Categories</h1>
        <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('categories.create') !!}">Add New</a>

        <div class="clearfix"></div>

        <div class="clearfix"></div>

        @include('admin.categories.table')
  </div>
@endsection
