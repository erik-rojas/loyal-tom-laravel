@extends('layouts.auth')
@section('title', 'LoyalTom')

@section('content')
    <div class="col-md-6 login-container bs-reset">
        <a href="/"><img style="width: 100px;" class="login-logo login-6" src="{{ asset('img/02-LoyalTom_blue.svg') }}" /></a>
    <div class="login-content">
        <h1 style="font-size: 25px; color: #203139;"><strong>Welcome to LoyalTom</strong></h1>
        <p style="color: #a7a7a7;">Time to make somebody feelding special!</p>
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter any username and password. </span>
            </div>
            <div class="row">
            <div class="form-group col-xs-6 {{ $errors->has('password') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="email" placeholder="" name="email" value="{{ old('email') }}" required autofocus /> </div>
            <div class="form-group col-xs-6 {{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="" name="password" required /> </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label class="rememberme mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>  Remember me
                        <span></span>
                    </label>
                </div>
                <div class="col-sm-8 text-right">
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}" id="forget-password" class="forget-password">Forgot Password?</a>
                    </div>
                    <button class="btn btn-custom" type="submit">Log In</button>
                </div>
            </div>

        </form>
        <!-- END LOGIN FORM -->

    </div>


@endsection
