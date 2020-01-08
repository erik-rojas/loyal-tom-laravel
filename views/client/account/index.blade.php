@extends('client.main')

@section('title', 'My account')

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->

            <h1 class="page-title"> My account
            </h1>
            <!-- BREADCRUMBS-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{route('home')}}">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span> My account</span>
                    </li>
                </ul>
            </div>
            <!-- END BREADCRUMBS-->

            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PROFILE SIDEBAR -->
                    <div class="profile-sidebar">
                        <!-- PORTLET MAIN -->
                        <div class="portlet light profile-sidebar-portlet ">
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic">
                                <img src="../img/avatar_male.png" class="img-responsive" alt=""> </div>
                            <!-- END SIDEBAR USERPIC -->
                            <!-- SIDEBAR USER TITLE -->
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name"> {{Auth::user()->clientAdvisor->name}} </div>
                                <div class="profile-usertitle-job"> {{Auth::user()->clientAdvisor->surname}} </div>
                            </div>
                            <!-- END SIDEBAR USER TITLE -->

                            <!-- SIDEBAR MENU -->
                            <div class="profile-usermenu">

                            </div>
                            <!-- END MENU -->
                        </div>
                        <!-- END PORTLET MAIN -->

                    </div>
                    <!-- END BEGIN PROFILE SIDEBAR -->
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_1_1">
                                                {!! Form::open(['route' => 'ca.account.update', 'method'=>'put']) !!}
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" name="name" value="{{Auth::user()->clientAdvisor->name}}" placeholder="{{Auth::user()->clientAdvisor->name}}" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" name="surname" value="{{Auth::user()->clientAdvisor->surname}}" placeholder="{{Auth::user()->clientAdvisor->surname}}" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Organization</label>
                                                    <input type="text" name="organization" value="{{Auth::user()->clientAdvisor->organization}}" placeholder="{{Auth::user()->clientAdvisor->organization}}" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Role</label>
                                                    <input type="text" name="role" value="{{Auth::user()->clientAdvisor->role}}" placeholder="{{Auth::user()->clientAdvisor->role}}" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" name="email" value="{{Auth::user()->email}}" placeholder="{{Auth::user()->email}}" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Mobile Number</label>
                                                    <input type="phone" name="number" value="{{Auth::user()->clientAdvisor->mobile_phone}}" placeholder="{{Auth::user()->clientAdvisor->mobile_phone}}" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Street</label>
                                                    <input type="text" name="street" value="{{Auth::user()->clientAdvisor->street}}" placeholder="{{Auth::user()->clientAdvisor->street}}" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">City</label>
                                                    <input type="text" name="city" value="{{Auth::user()->clientAdvisor->city}}" placeholder="{{Auth::user()->clientAdvisor->city}}" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">PLZ</label>
                                                    <input type="number" name="plz" value="{{Auth::user()->clientAdvisor->plz}}" placeholder="{{Auth::user()->clientAdvisor->plz}}" class="form-control" /> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Date of Birth</label>
                                                <input type="date" name="birthday" value="{{Auth::user()->clientAdvisor->birthday}}" placeholder="{{Auth::user()->clientAdvisor->birthday}}" class="form-control" /> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Country</label>
                                            <input type="text" name="country" value="{{Auth::user()->clientAdvisor->country}}" placeholder="{{Auth::user()->clientAdvisor->country}}" class="form-control" /> </div>
                                        <div class="margiv-top-10">
                                            <button type="submit" class="btn green"> Save Changes </button>
                                        </div>
                                        {!! Form::close() !!}

                                        <h2>Change Password</h2>
                                        {!! Form::open(['route' => 'ca.account.update-password', 'method'=>'PUT']) !!}

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">
                                                    <label for="old_password">Current password*:</label>
                                                    <input type="password" class="form-control" name="old_password" value="{{ old('old_password') }}" required>
                                                    @if ($errors->has('old_password'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('old_password') }}</strong>
                                                </span>
                                                    @endif
                                                </div>

                                                <div class="form-group {{ $errors->has('new_password') ? ' has-error' : '' }}">
                                                    <label for="new_password">New password*:</label>
                                                    <input type="password" class="form-control" name="new_password" value="{{ old('new_password') }}" required>
                                                    @if ($errors->has('new_password'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('new_password') }}</strong>
                                                </span>
                                                    @endif
                                                </div>

                                                <div class="form-group {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                                    <label for="new_password">Confirm password*:</label>
                                                    <input type="password" class="form-control" name="confirm_password" value="{{ old('confirm_password') }}" required>
                                                    @if ($errors->has('confirm_password'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                                </span>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <div class="margiv-top-10">
                                                        <button type="submit" class="btn green"> Update Password </button>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>



                                    </div>
                                    <!-- END PERSONAL INFO TAB -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
    </div>
    <!-- END CONTENT BODY -->
    </div>
@endsection