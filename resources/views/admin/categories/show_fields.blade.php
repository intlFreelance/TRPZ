<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $category->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $category->name !!}</p>
</div>

<div class="form-group">
    {!! Form::label('image', 'Image:') !!}
    <p><img src="{!! url('uploads/categories/'.$category->image) !!}" style="max-width:100%"/></p>
</div>
