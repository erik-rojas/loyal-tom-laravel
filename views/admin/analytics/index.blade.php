@extends('admin.main')

@section('title', 'Analytics')

@section('content')

    <div class="page-content">
        <h1 class="page-title">Analytics</h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Analytics</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="row">
            <!-- Number of occasions in DB-->
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="{{$occasions->count()}}">0</span>
                            </h3>
                            <small>Number of occasions in DB</small>
                        </div>
                        <div class="icon">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-1')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: {{round($occasions->count()*100/1200)}}%;" class="progress-bar progress-bar-success green-sharp">
                                <span class="sr-only">{{round($occasions->count()*100/1200)}}% progress</span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> progress </div>
                            <div class="status-number"> {{round($occasions->count()*100/1200)}}% </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Number of clients in DB-->
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="{{$clients_count}}">0</span>
                            </h3>
                            <small>Number of clients in DB</small>
                        </div>
                        <div class="icon">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-6')}}">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress"></div>
                        <div class="status"></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Number of reminders to send-->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Reminders by week</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-2')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="gchart_line_1" style="height:500px;"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- Counts based on OccasionType -->
            <div class="col-md-6">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Counts based on Occasion Type</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-3')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="gchart_pie_1" style="height:500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users engagement view -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Users engagement view</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-4')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="gchart_col_1" style="height:500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BEGIN Users Table-->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> Users LEADERBOARD</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-5')}}">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> CA name </th>
                                <th> CA surname </th>
                                <th> Clients recorded </th>
                                <th> Occasions recorded </th>
                                <th> Emails received </th>
                                <th> Reminder pages opened </th>
                                <th> Buy buttons clicked </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($client_advisors as $client_advisor)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$client_advisor->name}}</td>
                                        <td>{{$client_advisor->surname}}</td>
                                        <td>{{$client_advisor->clients->count()}}</td>
                                        <td>
                                            <?php $occasions_total = 0; ?>
                                            @foreach($client_advisor->clients as $client)
                                                <?php $occasions_total += $client->occasions->count(); ?>
                                            @endforeach
                                            {{$occasions_total}}
                                        </td>
                                        <td>
                                            <?php $reminders_total = 0; ?>
                                            @foreach($client_advisor->clients as $client)
                                                @foreach($client->occasions as $occasion)
                                                    <?php $reminders_total += $occasion->receivedReminders->count(); ?>
                                                @endforeach
                                            @endforeach
                                            {{$reminders_total}}
                                        </td>
                                        <td>
                                            <?php $reminders_seen_total = 0; ?>
                                            @foreach($client_advisor->clients as $client)
                                                @foreach($client->occasions as $occasion)
                                                    <?php $reminders_seen_total += $occasion->seenReminders->count(); ?>
                                                @endforeach
                                            @endforeach
                                            {{$reminders_seen_total}}
                                        </td>
                                        <td>
                                            <?php $reminders_clicked_total = 0; ?>
                                            @foreach($client_advisor->clients as $client)
                                                @foreach($client->occasions as $occasion)
                                                    @foreach($occasion->reminders as $one_reminder)
                                                        <?php $reminders_clicked_total += $one_reminder->clicks->count(); ?>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                            {{$reminders_clicked_total}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Users Table-->

        <div class="row">

            <!-- Age Pie -->
            <div class="col-md-6">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Counts based on Clients Age</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-7')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="age_pie" style="height:500px;"></div>
                    </div>
                </div>
            </div>

            <!-- Gender Pie -->
            <div class="col-md-6">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">COUNTS BASED ON CLIENTS GENDER</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-8')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="gender_pie" style="height:500px;"></div>
                    </div>
                </div>
            </div>

            <!-- Tag Pie -->
            <div class="col-md-6">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Counts based on Clients Tags</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-9')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="tag_pie" style="height:500px;"></div>
                    </div>
                </div>
            </div>

            <!-- Location Pie -->
            <div class="col-md-6">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Counts based on Clients Location</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-10')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="location_pie" style="height:500px;"></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Idea records view -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Idea records by months</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-11')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="ideas_gchart" style="height:500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Counts based on Feedback -->
            <div class="col-md-6">
                <div class="portlet light portlet-fit ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Counts based on Feedbacks</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" href="{{route('analytics.chart-12')}}" target="_blank">
                                <i class="icon-cloud-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="feedback_pie" style="height:500px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('javascript')

    <script src="https://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">
        function drawChart() {

            //Chart 1 - REMINDERS BY WEEK
            var e = new google.visualization.DataTable;
            e.addColumn("string", "Week"), e.addColumn("number", "Number of reminders to send"), e.addColumn("number", "Number of reminders sent"), e.addColumn("number", "Number of extra reminders sent"), e.addRows([
                @foreach($week_reminders as $key=>$week_reminder)
                    ["{{$key}}", {{$week_reminder['number_of_reminders_to_send']}}, {{$week_reminder['number_of_reminders_sent']}}, {{$week_reminder['number_of_extra_reminders']}}],
                @endforeach
            ]);
            var a = {
                    chart: {
                        title: "Number of reminders to sent, sent reminders, extra reminders",
                        subtitle: "Number of reminders per week"
                    }
                },
                n = new google.charts.Line(document.getElementById("gchart_line_1"));
            n.draw(e, a);

            // PIE CHART - Counts based on Occasion Type
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                    @foreach($occasion_types as $type)
                ["{!! $type->type !!}", {{$type->total}}],
                @endforeach
            ]);

            var options = {
                title: 'Occasion Types'
            };

            var chart = new google.visualization.PieChart(document.getElementById('gchart_pie_1'));
            chart.draw(data, options);

            // PIE CHART - AGE
            var data = google.visualization.arrayToDataTable([
                ['Clients', 'age'],
                    @foreach($client_ages as $age)
                ['{{$age->age}}', {{$age->total}}],
                @endforeach
            ]);

            var options = {
                title: 'Clients by Age'
            };

            var chart = new google.visualization.PieChart(document.getElementById('age_pie'));
            chart.draw(data, options);

            // PIE CHART - Gender
            var data = google.visualization.arrayToDataTable([
                ['Gender', 'Total'],
                    @foreach($client_genders as $gender)
                ['{{$gender->gender}}', {{$gender->total}}],
                @endforeach
            ]);

            var options = {
                title: 'Clients by Gender'
            };

            var chart = new google.visualization.PieChart(document.getElementById('gender_pie'));
            chart.draw(data, options);

            // PIE CHART - Tags
            var data = google.visualization.arrayToDataTable([
                ['Tag', 'Total'],
                    @foreach($client_tags as $key=>$client_tag)
                ['{{$key}}', {{$client_tag}}],
                @endforeach
            ]);

            var options = {
                title: 'Clients by Tags'
            };

            var chart = new google.visualization.PieChart(document.getElementById('tag_pie'));
            chart.draw(data, options);

            // PIE CHART - Location
            var data = google.visualization.arrayToDataTable([
                ['Location', 'Total'],
                    @foreach($client_locations as $client_location)
                ['{{$client_location->country}}', {{$client_location->total}}],
                @endforeach
            ]);

            var options = {
                title: 'Clients by Location'
            };

            var chart = new google.visualization.PieChart(document.getElementById('location_pie'));
            chart.draw(data, options);

            // PIE CHART - Feedback
            var data = google.visualization.arrayToDataTable([
                ['Feedback', 'Total'],
                @foreach($count_feedbacks as $count_feedback)
                ['{{$count_feedback->status}}', {{$count_feedback->total}}],
                @endforeach
                [' Ideas without feedback', {{$ideas_no_feedback}}]
            ]);

            var options = {
                title: 'Feedback count'
            };

            var chart = new google.visualization.PieChart(document.getElementById('feedback_pie'));
            chart.draw(data, options);

            // COLUMN CHART - Users engagement view
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Number of week');
            data.addColumn('number', 'Reminder Emails sent');
            data.addColumn('number', 'Extra Reminder Emails sent');
            data.addColumn('number', 'Reminder pages opened');
            data.addColumn('number', 'Buy buttons clicked');

            data.addRows([
                @foreach($engagements as $key=>$engagement)
                ["{{$key}}", {{$engagement['reminders_sent']}}, {{$engagement['extra_reminders_sent']}}, {{$engagement['pages_opened']}}, {{$engagement['clicks']}}],
                @endforeach
            ]);

            var options = {
                title: 'Users engagement view',
                focusTarget: 'category',
                hAxis: {
                    title: 'Number of a week',
                    {{--viewWindow: {--}}
                        {{--min: [{{key($engagements)-12}}],--}}
                        {{--max: [{{key($engagements)+1}} ]--}}
                    {{--},--}}
                },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('gchart_col_1'));
            chart.draw(data, options);

            // COLUMN CHART 7 - Idea records
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Number of Ideas');

            data.addRows([
                    @foreach($month_ideas as $key=>$month_idea)
                    ["{{$key}}", {{$month_idea['total']}}],
                    @endforeach
            ]);

            var options = {
                title: ' Idea records',
                focusTarget: 'category',
                hAxis: {
                    title: 'Number of ideas by months',
                },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('ideas_gchart'));
            chart.draw(data, options);

        }
        google.load("visualization", "1", {
            packages: ["corechart", "bar", "line"]
        }), google.load("visualization", "1.1", {
            packages: ["gantt"]
        }), google.setOnLoadCallback(drawChart);
    </script>


@endsection

@section('stylesheets')

@endsection