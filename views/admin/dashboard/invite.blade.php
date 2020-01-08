@extends('admin.main')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">


            <h1 class="page-title">  Users
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

                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                <tr>
                                    <th> First name </th>
                                    <th> Surname </th>
                                    <th> Email </th>
                                    <th> Organization </th>
                                    <th> Role </th>
                                    <th> Mobile Phone </th>
                                    <th> Street </th>
                                    <th> City </th>
                                    <th> Country </th>
                                    <th> PLZ </th>
                                    <th> Status </th>
                                    <th> Delete </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($clientAdvisors))
                                @foreach($clientAdvisors as $clientAdvisor)
                                <tr>
                                    <td>{{$clientAdvisor->user->name}}</td>
                                    <td>{{$clientAdvisor->surname}}</td>
                                    <td>{{$clientAdvisor->user->email}}</td>
                                    <td>{{$clientAdvisor->organization}}</td>
                                    <td>{{$clientAdvisor->role}}</td>
                                    <td class="center"> {{$clientAdvisor->mobile_phone}} </td>
                                    <td>{{$clientAdvisor->street}}</td>
                                    <td>{{$clientAdvisor->city}}</td>
                                    <td>{{$clientAdvisor->country}}</td>
                                    <td>{{$clientAdvisor->plz}}</td>
                                    <td>
                                       <a href="{{route('ca.edit', $clientAdvisor->id)}}">Edit</a>
                                    </td>
                                    <td>
                                        <script>

                                            function ConfirmDelete()
                                            {
                                                var x = confirm("Do you really want to delete this User?");
                                                if (x)
                                                    return true;
                                                else
                                                    return false;
                                            }

                                        </script>
                                        {{ Form::open(['route' => ['ca.delete',$clientAdvisor->user_id], 'onsubmit' => 'return ConfirmDelete()', 'method' => 'DELETE']) }}
                                        <button type="submit">Delete </button>
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">  User Invitations</span>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <button id="add_invitation" class="btn sbold green"> Add New
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="btn-group pull-right">
                                            <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li id="sendToChecked">
                                                    <a href="javascript:;">
                                                        <i class="fa fa-envelope"></i>
                                                        Send invitation to checked
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                <thead>
                                <tr>
                                    <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                            <span></span>
                                        </label>
                                    </th>
                                    <th> Name </th>
                                    <th> Email </th>
                                    <th> Code </th>
                                    <th> Status </th>
                                    <th> Admin ID </th>
                                    <th> Created </th>
                                    <th> Actions </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($registrationStatuses as $registrationStatus)

                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" value="1" />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            {{$registrationStatus->name}}
                                        </td>
                                        <td>
                                            <a class="email" href="mailto:{{$registrationStatus->email}}"> {{$registrationStatus->email}} </a>
                                        </td>
                                        <td> {{$registrationStatus->code}}</td>
                                        <td>
                                            @if ($registrationStatus->status == 0)
                                                <span class="label label-sm label-info">Pending</span>
                                            @else
                                                <span class="label label-sm label-success">Registered</span>
                                            @endif

                                            @if($registrationStatus->email_status == 1 )
                                                    <span class="label label-sm label-info">sent</span>
                                            @endif
                                        </td>
                                        <td class="center">{{$registrationStatus->created_by}}</td>
                                        <td class="center">{{$registrationStatus->created_at}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-left" role="menu">
                                                    <li>
                                                        <a href="{{route('invite.sendemail',[$registrationStatus->email, $registrationStatus->code, $registrationStatus->name])}}">
                                                            <i class="icon-docs"></i> Send email </a>
                                                    </li>
                                                    <li>
                                                        {{ Form::open(['route' => ['delete.invite',$registrationStatus->email], 'method' => 'DELETE']) }}
                                                        <button type="submit" style="background: none;box-shadow: none;border: none;">
                                                            <i class="icon-trash"></i> Delete invitation </button>
                                                        {{ Form::close() }}

                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <div style="display: none;" id="invitation_form" class="row">
                <div class="col-md-12">
                    <!-- BEGIN VALIDATION STATES-->
                    <div class="portlet light portlet-fit portlet-form ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-layers font-red"></i>
                                <span class="caption-subject font-red sbold uppercase">Add New Clent Advisor</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="icon-cloud-upload"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="icon-wrench"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                    <i class="icon-trash"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM-->
                            {!! Form::open(['route' => ['invite.store'], 'method'=>'POST', 'files' => 'false']) !!}
                                <div class="form-body">
                                    <div class="form-group form-md-line-input form-md-floating-label">
                                        <input type="text" class="form-control" name="email[]" id="form_control_1">
                                        <label for="form_control_1">Pattern: name email,name email...</label>
                                        <span class="help-block">Some help goes here...</span>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn dark">Save</button>
                                            <button type="reset" class="btn default">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END VALIDATION STATES-->
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
        });

        jQuery('#sample_1').change(function(){
            yourArray = [];
            jQuery('#sample_1 tr.active').each(function(){
                yourArray.push($(this).find('.email').text());
            });
            console.log(yourArray);
        });

        //Click SendToChecked
        $('#sendToChecked').on('click', function(e){
            e.preventDefault;
            var array = yourArray;
            var token = "{{ csrf_token() }}";
            var url = "{{route('admin.sendAll')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    array:array,
                    _token:token
                },
                success: function(response) {
                    alert(response);
                }
            });
        });

    </script>
@endsection