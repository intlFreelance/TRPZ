@extends('layouts.app')

@section('content')
  <div class="container">
        <h1 class="pull-left">Purchases</h1>

        <div class="clearfix"></div>

        <div class="clearfix"></div>

        @include('admin.purchases.table')
  </div>
@endsection
