@extends('admin.main')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">


            <h1 class="page-title">  User Edit
            </h1>
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light portlet-fit ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-red"></i>
                                <span class="caption-subject font-red sbold uppercase">Users</span>
                            </div>

                        </div>
                        <div class="portlet-body">


                            {!! Form::open(['route' => ['ca.edit', $clientAdvisor->id], 'method'=>'put']) !!}
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input type="text" name="name" value="{{$clientAdvisor->name}}" placeholder="{{$clientAdvisor->name}}" class="form-control" /> </div>
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input type="text" name="surname" value="{{$clientAdvisor->surname}}" placeholder="{{$clientAdvisor->surname}}" class="form-control" /> </div>
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="email" name="email" value="{{$clientAdvisor->user->email}}" placeholder="{{$clientAdvisor->user->email}}" class="form-control" /> </div>
                                <div class="form-group">
                                    <label class="control-label">Mobile Number</label>
                                    <input type="phone" name="number" value="{{$clientAdvisor->mobile_phone}}" placeholder="{{$clientAdvisor->mobile_phone}}" class="form-control" /> </div>
                                <div class="form-group">
                                    <label class="control-label">Street</label>
                                    <input type="text" name="street" value="{{$clientAdvisor->street}}" placeholder="{{$clientAdvisor->street}}" class="form-control" /> </div>
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input type="text" name="city" value="{{$clientAdvisor->city}}" placeholder="{{$clientAdvisor->city}}" class="form-control" /> </div>
                                <div class="form-group">
                                    <label class="control-label">PLZ</label>
                                    <input type="number" name="plz" value="{{$clientAdvisor->plz}}" placeholder="{{$clientAdvisor->plz}}" class="form-control" /> </div>
                        <div class="form-group">
                            <label class="control-label">Date of Birth</label>
                            <input type="date" name="birthday" value="{{$clientAdvisor->birthday}}" placeholder="{{$clientAdvisor->birthday}}" class="form-control" /> </div>

                            <div class="form-group">
                                <label class="control-label">Country</label>
                                <input type="text" name="country" value="{{$clientAdvisor->country}}" placeholder="{{$clientAdvisor->country}}" class="form-control" /> </div>

                            <div class="form-group">
                                <label>Occasions available:</label>
                                <input type="text" value="{{$occasions_available}}" class="form-control" readonly />
                            </div>

                            <div class="form-group">
                                <label>Occasions used by {{$clientAdvisor->name}}:</label>
                                <input type="text" value="{{$occasions_count}}" class="form-control" readonly />
                            </div>

                            <div class="form-group">
                                <label for="occasion_limit">Occasion Limit:</label>
                                <input type="number" min="{{$occasions_count}}" max="{{$occasions_available}}" name="occasion_limit" value="{{$clientAdvisor->occasion_limit}}" class="form-control" />
                            </div>

                            <div class="margiv-top-10">
                                <button type="submit" class="btn green"> Save Changes </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>


        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
@section('javascript')
    <script>

        jQuery('#add_invitation').click(function(){
            jQuery('#invitation_form').slideToggle();
        })
    </script>
@endsection