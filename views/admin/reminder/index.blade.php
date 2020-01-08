@extends('admin.main')

@section('title', 'All Reminders')

@section('content')

    <div class="page-content">
        <h1 class="page-title"> All Reminders</h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>All Reminders</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Reminders Table
                    </div>
                    <div class="panel-body">
                        <div class="">
                            <table class="table table-striped table-bordered table-hover" id="reminders-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reminder status</th>
                                    <th>Actions</th>
                                    <th>Reminder URL <small>Email/SMS/Seen</small></th>
                                    <th>Reminder due date</th>
                                    <th>User</th>
                                    <th>Occasion type</th>
                                    <th>Occasion date</th>
                                    <th>Client name</th>
                                    <th>Client location</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Enjoys</th>
                                    <th>Doesn't enjoy</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($occasions as $occasion)
                                    <tr>
                                    @if(!$occasion->relative)
                                    <td>{{$loop->iteration}}</td>

                                    <td>
                                        @if($occasion->reminders->count())
                                            @if($occasion->reminders->count() > 1)
                                                @if($occasion->lastReminder->status == 'Scheduled')
                                                    <span class="label label-warning">Repeated</span>
                                                @elseif($occasion->lastReminder->status == 'Draft')
                                                    <span class="label label-default">Draft</span>
                                                @endif
                                            @else
                                                @if($occasion->lastReminder->status == 'Scheduled')
                                                    @if($occasion->lastReminder->email_sent && $occasion->lastReminder->sms_sent)
                                                        <span class="label label-primary"><span class="glyphicon glyphicon-send"></span> Sent</span>
                                                        @if($occasion->lastReminder->email_sent)
                                                            <span class="label label-primary">
                                                                <span class="glyphicon glyphicon-envelope"></span> Email
                                                            </span>
                                                        @endif
                                                        @if($occasion->lastReminder->sms_sent)
                                                            <span class="label label-primary">
                                                                <span class="glyphicon glyphicon-phone"></span> SMS
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="label label-info">Scheduled</span>
                                                    @endif
                                                @elseif($occasion->lastReminder->status == 'Draft')
                                                    <span class="label label-default">Draft</span>
                                                @endif
                                            @endif
                                        @else
                                            <span class="label label-danger">Pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if(isset($occasion->lastReminder->status) && $occasion->lastReminder->status == 'Draft')
                                            <a href="{{route('reminders.create', $occasion->id)}}" class="btn btn-success">Return to Draft</a>
                                        @else
                                            <a href="{{route('reminders.create', $occasion->id)}}" class="btn btn-success">Create Reminder</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($occasion->reminders))
                                            @foreach($occasion->reminders as $one_reminder)
                                                @if($one_reminder->status != 'Draft')
                                                    <div>
                                                        <a href="{{route('reminders.preview', $one_reminder->id)}}" target="_blank">Reminder {{$loop->iteration}}</a>
                                                        @if($one_reminder->email_sent)
                                                            <span class="label label-primary">
                                                                <span class="glyphicon glyphicon-envelope"></span>
                                                            </span>
                                                        @endif
                                                        @if($one_reminder->sms_sent)
                                                            <span class="label label-primary">
                                                                <span class="glyphicon glyphicon-phone"></span>
                                                            </span>
                                                        @endif
                                                        @if($one_reminder->seen)
                                                            <span class="label label-primary">
                                                                <span class="glyphicon glyphicon-eye-open"></span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span href="#">Reminder {{$loop->iteration}} - Draft</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td data-order="{{strtotime($occasion->due_date)}}">{{date('d.m.Y', strtotime($occasion->due_date))}}</td>
                                    <td>{{$occasion->client->clientAdvisor->user->name}} {{$occasion->client->clientAdvisor->surname}}</td>
                                    <td>{{$occasion->type}}</td>
                                    <td>week {{$occasion->date}}</td>
                                    <td>{{$occasion->client->name}} {{$occasion->client->surname}}</td>
                                    <td>{{ $occasion->client->country ? $occasion->client->country : $occasion->client->address }}</td>
                                    <td>{{$occasion->client->gender}}</td>
                                    <td>{{$occasion->client->age}}</td>
                                    <td>
                                        <?php $enjoys = explode(",", $occasion->client->like);?>
                                        @foreach($enjoys as $enjoy)
                                            @if(!($enjoy === 'null'))
                                                <span class="label label-default">{{$enjoy}}</span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <?php $enjoys = explode(",", $occasion->client->dislike);?>
                                        @foreach($enjoys as $enjoy)
                                            @if(!($enjoy === 'null'))
                                                <span class="label label-default">{{$enjoy}}</span>
                                            @endif
                                        @endforeach
                                    </td>
                                    @else
                                        <td>{{$loop->iteration}}</td>

                                        <td>
                                            @if($occasion->reminders->count())
                                                @if($occasion->reminders->count() > 1)
                                                    @if($occasion->lastReminder->status == 'Scheduled')
                                                        <span class="label label-warning">Repeated</span>
                                                    @elseif($occasion->lastReminder->status == 'Draft')
                                                        <span class="label label-default">Draft</span>
                                                    @endif
                                                @else
                                                    @if($occasion->lastReminder->status == 'Scheduled')
                                                        @if($occasion->lastReminder->email_sent && $occasion->lastReminder->sms_sent)
                                                            <span class="label label-primary"><span class="glyphicon glyphicon-send"></span> Sent</span>
                                                            @if($occasion->lastReminder->email_sent)
                                                                <span class="label label-primary">
                                                                    <span class="glyphicon glyphicon-envelope"></span> Email
                                                                </span>
                                                            @endif
                                                            @if($occasion->lastReminder->sms_sent)
                                                                <span class="label label-primary">
                                                                    <span class="glyphicon glyphicon-phone"></span> SMS
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span class="label label-info">Scheduled</span>
                                                        @endif
                                                    @elseif($occasion->lastReminder->status == 'Draft')
                                                        <span class="label label-default">Draft</span>
                                                    @endif
                                                @endif
                                            @else
                                                <span class="label label-danger">Pending</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if(isset($occasion->lastReminder->status) && $occasion->lastReminder->status == 'Draft')
                                                <a href="{{route('reminders.create', $occasion->id)}}" class="btn btn-success">Return to Draft</a>
                                            @else
                                                <a href="{{route('reminders.create', $occasion->id)}}" class="btn btn-success">Create Reminder</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($occasion->reminders))
                                                @foreach($occasion->reminders as $one_reminder)
                                                    @if($one_reminder->status != 'Draft')
                                                        <div>
                                                            <a href="{{route('reminders.preview', $one_reminder->id)}}" target="_blank">Reminder {{$loop->iteration}}</a>
                                                            @if($one_reminder->email_sent)
                                                                <span class="label label-primary">
                                                                    <span class="glyphicon glyphicon-envelope"></span>
                                                                </span>
                                                            @endif
                                                            @if($one_reminder->sms_sent)
                                                                <span class="label label-primary">
                                                                    <span class="glyphicon glyphicon-phone"></span>
                                                                </span>
                                                            @endif
                                                            @if($one_reminder->seen)
                                                                <span class="label label-primary">
                                                                    <span class="glyphicon glyphicon-eye-open"></span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span href="#">Reminder {{$loop->iteration}} - Draft</span>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td data-order="{{strtotime($occasion->due_date)}}">{{date('d.m.Y', strtotime($occasion->due_date))}}</td>
                                        <td>{{$occasion->client->clientAdvisor->user->name}} {{$occasion->client->clientAdvisor->surname}}</td>
                                        <td>{{$occasion->type}}</td>
                                        <td>week {{$occasion->date}}</td>
                                        <td>{{$occasion->client->name}}</td>
                                        <td>{{$occasion->client->country}}</td>
                                        <td>{{$occasion->gender}}</td>
                                        <td>{{$occasion->age}}</td>
                                        <td>
                                            <?php $enjoys = explode(",", $occasion->like);?>
                                            @foreach($enjoys as $enjoy)
                                                @if(!($enjoy === 'null'))
                                                    <span class="label label-default">{{$enjoy}}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <?php $enjoys = explode(",", $occasion->dislike);?>
                                            @foreach($enjoys as $enjoy)
                                                @if(!($enjoy === 'null'))
                                                    <span class="label label-default">{{$enjoy}}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('javascript')

    <script src="{{ asset('css/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            table = $('#reminders-table').DataTable({
                "pageLength": 50,
                "sScroll": false,
            });
        });
    </script>
@endsection

@section('stylesheets')

    <link href="{{ asset('css/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .label{
            display:inline-block;
            margin-top:4px;
        }
        .fa-warning{
            color:#9b000b;
            float:right;
            margin-top:4px;
        }
    </style>

@endsection