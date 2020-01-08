@extends('admin.main')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="page-content">
        <h1 class="page-title"> LoyalTom Dashboard<small> </small></h1>

        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-12">
                        @if($this_week['total'] != 0)
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 ">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-green-sharp" style="font-size: 24px;">Reminders this week</h3>
                                            <small>{{Carbon\Carbon::now()->startOfWeek()->format('d.m')}} - {{Carbon\Carbon::now()->endOfWeek()->format('d.m')}}</small>
                                            <h5><strong>{{$this_week['scheduled']}}/{{$this_week['total']}} Scheduled</strong></h5>
                                            <h5><strong>{{$this_week['email']}}/{{$this_week['total']}} Email Sent</strong></h5>
                                            <h5><strong>{{$this_week['sms']}}/{{$this_week['total']}} SMS Sent</strong></h5>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                    <span style="width: {{round((($this_week['scheduled']+$this_week['email']+$this_week['sms'])*100)/($this_week['total']*3))}}%;" class="progress-bar progress-bar-success green-sharp">
                                        <span class="sr-only">{{round((($this_week['scheduled']+$this_week['email']+$this_week['sms'])*100)/($this_week['total']*3))}}% progress</span>
                                    </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> Fulfillment </div>
                                            <div class="status-number"> {{round((($this_week['scheduled']+$this_week['email']+$this_week['sms'])*100)/($this_week['total']*3))}}% </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 ">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-green-sharp" style="font-size: 24px;">Reminders this week</h3>
                                            <small>{{Carbon\Carbon::now()->startOfWeek()->format('d.m')}} - {{Carbon\Carbon::now()->endOfWeek()->format('d.m')}}</small>
                                            <h5><strong>0/0 Scheduled</strong></h5>
                                            <h5><strong>0/0 Email Sent</strong></h5>
                                            <h5><strong>0/0 SMS Sent</strong></h5>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                            <span style="width: 0%;" class="progress-bar progress-bar-success red-haze">
                                                <span class="sr-only">0% change</span>
                                            </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> Fulfillment </div>
                                            <div class="status-number"> 0% </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($next_week['total'] != 0)
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 ">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-red-haze"  style="font-size: 24px;">Reminders next week</h3>
                                            <small>{{Carbon\Carbon::now()->addWeeks(1)->startOfWeek()->format('d.m')}} - {{Carbon\Carbon::now()->addWeeks(1)->endOfWeek()->format('d.m')}}</small>
                                            <h5><strong>{{$next_week['scheduled']}}/{{$next_week['total']}} Scheduled</strong></h5>
                                            <h5><strong>{{$next_week['email']}}/{{$next_week['total']}} Email Sent</strong></h5>
                                            <h5><strong>{{$next_week['sms']}}/{{$next_week['total']}} SMS Sent</strong></h5>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                        <span style="width: {{round((($next_week['scheduled']+$next_week['email']+$next_week['sms'])*100)/($next_week['total']*3))}}%;" class="progress-bar progress-bar-success red-haze">
                                            <span class="sr-only">{{round((($next_week['scheduled']+$next_week['email']+$next_week['sms'])*100)/($next_week['total']*3))}}% change</span>
                                        </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> Fulfillment </div>
                                            <div class="status-number"> {{round((($next_week['scheduled']+$next_week['email']+$next_week['sms'])*100)/($next_week['total']*3))}}% </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 ">
                                    <div class="display">
                                        <div class="number">
                                            <h3 class="font-red-haze"  style="font-size: 24px;">Reminders next week</h3>
                                            <small>{{Carbon\Carbon::now()->addWeeks(1)->startOfWeek()->format('d.m')}} - {{Carbon\Carbon::now()->addWeeks(1)->endOfWeek()->format('d.m')}}</small>
                                            <h5><strong>0/0 Scheduled</strong></h5>
                                            <h5><strong>0/0 Email Sent</strong></h5>
                                            <h5><strong>0/0 SMS Sent</strong></h5>
                                        </div>
                                    </div>
                                    <div class="progress-info">
                                        <div class="progress">
                                        <span style="width: 0%;" class="progress-bar progress-bar-success red-haze">
                                            <span class="sr-only">0% change</span>
                                        </span>
                                        </div>
                                        <div class="status">
                                            <div class="status-title"> Fulfillment </div>
                                            <div class="status-number"> 0% </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row" style="padding:0 15px;">
                    <div class="col-md-12">
                        <div class="portlet light portlet-fit calendar">
                            <div class="portlet-title"></div>
                            <div class="portlet-body">
                                <div id="calendarNew" class="has-toolbar fc fc-ltr fc-unthemed"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-globe font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">Next Reminders to send</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <ul class="feeds">
                            @foreach($upcoming_occasions as $occasion)
                                <li style="position:relative;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-danger">
                                                    <i class="fa fa-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> {{$occasion->client->name}}'s {{$occasion->type}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> {{Carbon\Carbon::createFromFormat('Y-m-d', $occasion->due_date)->format('d.m.Y')}} </div>
                                    </div>
                                    <a href="{{route('reminders.create', $occasion->id)}}" class="btn btn-danger btn-xs" style="display:block;position:absolute;right:90px;top:1px;width:130px;">
                                        Create Reminder <i class="fa fa-mail-forward"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

    {{--<script src="/js/fullcalendar.min.js" type="text/javascript"></script>--}}
    <script type="text/javascript">

        $(document).ready(function() {
            $('#calendarNew').fullCalendar({
                header: {
                    left: 'prev,next, today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: '<?=date('Y-m-d')?>',
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events:[
                        @foreach($occasions as $occasion)
                    {
                        title: '{{$occasion->client->name}} - {{$occasion->type}}',
                        start: '{{$occasion->due_date}}'
                    },
                    @endforeach
                ]

            });
        });

    </script>
@endsection

@section('stylesheets')
    {{--<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css" rel="stylesheet" />--}}

    <style>
        .date{
            float:right;
        }
    </style>
@endsection