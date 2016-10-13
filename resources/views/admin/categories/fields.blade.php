<div class="panel-body">
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required'=>'required']) !!}
    </div>

    <!-- Image -->
    <div class="form-group col-sm-6">
        {!! Form::label('image', 'Image:') !!}
        {!! Form::file('image', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="panel-footer">
        <!-- Submit Field -->
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('categories.index') !!}" class="btn btn-default">Cancel</a>
    </div>
</div>

