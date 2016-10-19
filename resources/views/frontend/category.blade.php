@extends('layouts.frontend')

@section('content')
<div class="container-full category">
    <div class="container">
        <h1>{!! $category->name !!}</h1>    
    </div>
</div>
<div class="packages-container">
    @foreach($category->packages as $package)
    <div class="package-container">
        <a href="{!! url('package/'.$package->id) !!}">
            <div class="container-full category-container category-container-image" style="background-image: url( {!! url('uploads/packages/'.$package->mainImage) !!} )">
                <div class="package-container-title"> <h3>{!! $package->name !!}</h3> </div>
            </div>    
        </a>
    </div>
@endforeach
</div>
@endsection