@extends('layouts.app')

@section('content')
  <div class="container">
    @include('admin.categories.show_fields')

    <div class="form-group">
           <a href="{!! route('categories.index') !!}" class="btn btn-default">Back</a>
    </div>
  </div>
@endsection
