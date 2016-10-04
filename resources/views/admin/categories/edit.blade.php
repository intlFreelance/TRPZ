@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Category</h1>
            </div>
        </div>


        <div class="row">
            {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'patch']) !!}

            @include('admin.categories.fields')

            {!! Form::close() !!}
        </div>
      </div>
@endsection
