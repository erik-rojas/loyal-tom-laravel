@extends('layouts.auth')
@section('title', 'LoyalTom')

@section('content')
    <style>
        html, body{
            overflow-x: hidden;
        }
    </style>
    <div class="col-md-6 login-container bs-reset">
        <a href="/"><img style="width: 40px;" class="login-logo login-6 register-logo" src="{{ asset('img/02-LoyalTom_blue.svg') }}" /></a>
        <div class="login-content register-content">
            <h1 style="color: #203139; font-size: 25px; margin-bottom: 20px; margin-top: -20px;"><strong>Welcome to LoyalTom</strong></h1>
            <p style="color: #203139; font-size: 15px; margin-bottom: 30px;">Register your details</p>
            <!-- BEGIN REGISTRATION FORM -->
            <form class="login-form register-form" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="row text-register-2">
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">Name</label>
                        <input  pattern="\D [^0-9]" class="form-control form-control-solid placeholder-no-fix form-group " type="text"  name="name" value="{{ old('name') }}" required autofocus /> </div>
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">Surname</label>
                        <input class="form-control placeholder-no-fix" type="text"  name="surname" value="{{ old('surname') }}" required />
                    </div>
                </div>
                <div class="row text-register-2">
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">Organization</label>
                        <input  pattern="\D [^0-9]" class="form-control form-control-solid placeholder-no-fix form-group" type="text"  name="organization" value="{{ old('organization') }}" required autofocus />
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">Role</label>
                        <input class="form-control placeholder-no-fix" type="text"  name="role" value="{{ old('role') }}" required />
                    </div>
                </div>
                <div class="row text-register-2">
                    <div class="form-group  col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                        <label class="control-label visible-ie8 visible-ie9 text-register">Email</label>
                        <input class="form-control placeholder-no-fix" type="email"  name="email" value="{{ old('email') }}" required /> </div>
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">Mobile Phone</label>
                        <input class="form-control placeholder-no-fix" type="phone"  name="phone" value="{{ old('phone') }}" required /> </div>
                </div>
                <div class="row text-register-2">
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">Address</label>
                        <input class="form-control placeholder-no-fix" type="text"  name="street" value="{{ old('street') }}" required /> </div>
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">Postal code</label>
                        <input class="form-control placeholder-no-fix" type="number"  name="plz" value="{{ old('plz') }}" required /> </div>
                </div>
                <div class="row text-register-2">
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">City</label>
                        <input class="form-control placeholder-no-fix" type="text"  name="city" value="{{ old('city') }}" required />
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">Country</label>
                        <input class="form-control placeholder-no-fix" type="text"  name="country" value="{{ old('country') }}" required /> </div>
                </div>
                <div class="row text-register-2">
                    <div class="form-group col-md-6{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label hide-media text-register">Activation Code <a href="mailto:welcome@loyaltom.com" style="color: #a7a7a7;">(get a code)</a></label>

                        @if(Request::get('code'))
                            <input class="form-control placeholder-no-fix" type="text"  name="code" required value="{{ Request::get('code') }}"/>
                        @else
                            <input class="form-control placeholder-no-fix" type="text"  name="code" required value="{{ old('code') }}"/>
                        @endif
                    </div>


                    <div class="form-group col-md-6{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label text-register" style="padding-bottom: 5px;">Date of Birth - dd/mm/yyyy</label>
                        <input class="form-control placeholder-no-fix" type="date"   name="birthday"  value="{{ old('birthday') }}" autocomplete="off" required/> </div>
                </div>
                <div class="row text-register-2">
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">New password</label>
                        <input class="form-control placeholder-no-fix" type="password"  name="password" required /> </div>
                    <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label visible-ie8 visible-ie9 text-register">Confirm the new password</label>
                        <input class="form-control placeholder-no-fix" type="password"  name="password_confirmation" required /> </div>
                </div>
                <div class="form-actions">
                    <button type="submit" id="register-submit-btn" class="btn  uppercase pull-right btn-custom" style="z-index: 9999; background-color:#203139; border-color:#203139; margin-bottom: 40px;">Submit</button>
                </div>

            </form>
            <!-- END REGISTRATION FORM -->

        </div>

@endsection
