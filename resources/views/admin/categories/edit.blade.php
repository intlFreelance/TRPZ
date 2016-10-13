@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Edit Category</h2></div>
                    {!! Form::model($category, ['route' => ['categories.update', $category->id], 'files' => true, 'method' => 'patch']) !!}
                        @include('admin.categories.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
