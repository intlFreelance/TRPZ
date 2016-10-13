<div class="panel-body">
    <div class="row">
        <!-- First Name Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('firstName', 'First Name:') !!}
            {!! Form::text('firstName', null, ['class' => 'form-control', 'disabled'=>'disabled']) !!}
        </div>
        <!-- Last Name Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('lastName', 'Last Name:') !!}
            {!! Form::text('lastName', null, ['class' => 'form-control', 'disabled'=>'disabled']) !!}
        </div>
        <!-- Email Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'disabled'=>'disabled']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Address</div>
                <div class="panel-body">
                    <div class="row">
                         <div class="form-group col-sm-6">
                            {!! Form::label("address[line1]", 'Line 1:') !!}
                            {!! Form::text("address[line1]", null,  ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label("address[line2]", 'Line 2:') !!}
                            {!! Form::text("address[line2]", null,  ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            {!! Form::label("address[city]", 'City:') !!}
                            {!! Form::text("address[city]", null,  ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                        </div>
                        <div class="form-group col-sm-4">
                            {!! Form::label("address[state]", 'State:') !!}
                            {!! Form::text("address[state]", null,  ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                        </div>
                        <div class="form-group col-sm-4">
                            {!! Form::label("address[zip]", 'Zip Code:') !!}
                            {!! Form::text("address[zip]", null,  ['class' => 'form-control', 'disabled'=>'disabled']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<div class="panel-footer">
        <!-- Submit Field -->
    <div class="form-group">
        <a href="{!! route('customers.index') !!}" class="btn btn-default">Back</a>
    </div>
</div>