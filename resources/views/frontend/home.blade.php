@extends('layouts.frontend')

@section('content')
<div class="container-full image-bg" style="background-image:url('{{ url('img/two_jack_lake_canada-1920x1080-1.jpg')}}')">
  <div class="container hero package-container-title-left">
    <h3>Hang Ten in Hawaii</h3>
    <h4><i class="fa fa-map-marker" aria-hidden="true"></i> Honolulu, HI • From $799</h4>
  </div>
</div>
<div class="container-full cta-banner">
    <div id="homepage-cta-banner">
        <p>Win a trip to Chiang Mai! <a href="#" class="purple-button button" style="margin-left: 20px;">View Details</a></p>
    </div>
</div>
@foreach($categories as $category)
<div class="container-full category-container category-container-image" style="background-image: url( {!! url('uploads/categories/'.$category->image) !!} )">
    <div class="box">
        <div class="overlay">
            <div class="package-container-title">
                <h3><a href="{!! url('category/'.$category->id) !!}" class="title-link">{!! $category->name !!}</a></h3>
            </div>
            <br/>
            <a href="{!! url('category/'.$category->id) !!}" class="button hero-button">View</a>
        </div>
        <div class="package-container-title">
            <h3>{!! $category->name !!}</h3>
        </div>
    </div>
</div>
    
@endforeach
@endsection
