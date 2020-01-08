@extends('client.main')

@section('title', 'LoyalTom')

@section('content')

<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">

        <div id="header-h1">
			<h1 class="page-title"> Hello, {{Auth::user()->name}}
			</h1>
		</div>


        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="dashboard-stat2 ">
                    <h3>
                        <div id="dashboard-stat2-div-1" style="padding-right: 50%">You have {{(Auth::user()->clientAdvisor->occasion_limit) - $occasionAll}} out of {{Auth::user()->clientAdvisor->occasion_limit}} occasions left</div>
                        <div id="dashboard-stat2-div-2" style="float: right; position: relative;bottom: 32px;">Expiration on:<br/>{{$expiration->value}}</div>
                    </h3>
                </div>

            </div>
        </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="portlet light portlet-fit  calendar">
                            <div class="portlet-title">
                                <h3>New Reminders</h3>
                            </div>
                        <div class="portlet-body">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;"><div class="some-block" style="height: 415px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible="0" data-initialized="1">
                                    <ul class="feeds">
                                       @if($current_reminders->count() == 0 )
                                            <h3>There are currently no new reminders that require your attention</h3>
                                        @endif
                                        @foreach($current_reminders as $reminder)
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> Your client {{$reminder->occasion->client->name}} has <a href="{{route('ca.reminders.show', $reminder->id)}}"> <span style="font-style: italic;">{{$reminder->occasion->type}}</span>
                                                                </a>
                                                            </div>
                                                            <div class="date" style="padding-left:35px;">
                                                                <small>Week starting on: {{Carbon\Carbon::createFromFormat('Y-m-d',$reminder->occasion->due_date)->addWeeks(2)->format('d.m.Y')}}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </li>

                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="portlet light portlet-fit  calendar">
                            <div class="portlet-title">
                                <h3>Client occasions</h3>
                                <br/>
                            </div>
                            <div class="portlet-body">  <div id="calendarNew" class="has-toolbar fc fc-ltr fc-unthemed"></div></div>
                        </div>
                    </div>
                </div>



    </div>

    <!-- END CONTENT BODY -->
</div>

<!-- END QUICK SIDEBAR -->
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
                firstDay: 1,
                defaultDate: '<?=date('Y-m-d')?>',
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events:[
                        @foreach($occasions as $occasion)
                    {
                        title: '{{$occasion->client->name}} - {{$occasion->type}}',
                        start: '{{Carbon\Carbon::parse($occasion->due_date)->addDay(14)->toDateString()}}',
                        url: '{{route('ca.occasionitem', $occasion->client->id)}}'


                    },
                    @endforeach
                ]

            });
        });

    </script>
@endsection

@section('stylesheets')

@endsection