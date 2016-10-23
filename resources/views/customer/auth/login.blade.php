@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-3">
            
            <h1 class="blue-header">Account Login</h1>
                    <form role="form" method="POST" action="{{ url('/customer/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group col-md-8 {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                            <div>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-8 {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group col-md-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 ">
                                <a class="btn btn-link pull-left" href="{{ url('/customer/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                                <a class="btn btn-link pull-right" href="{{ url('/customer/register') }}">
                                    Need a Trpz Account? Sign Up
                                </a>
                            </div>
                        </div>
                        <div class="form-group col-md-8">
                            <button type="submit" class="btn btn-success full-width">
                                Sign In
                            </button>
                        </div>
                        
                    </form>
                </div>
    </div>
</div>
<div class="container-fluid">
    @include('frontend.additional')    
</div>
@endsection
