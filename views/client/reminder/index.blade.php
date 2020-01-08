@extends('client.main')

@section('title', 'All Reminders')

@section('content')

    <div class="page-content-wrapper">
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
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs ">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab"> Current </a>
                            </li>
                            <li>
                                <a href="#tab_2" data-toggle="tab"> Upcoming </a>
                            </li>
                            <li>
                                <a href="#tab_3" data-toggle="tab"> Expired </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">

                                <div class="row">
                                @foreach($current_reminders as $reminder)
                                    <div class="col-sm-6 col-md-3">
                                        <div class="thumbnail">
                                            <div class="caption">
                                                <h3>{{$reminder->occasion->client->name}}'s {{$reminder->occasion->type}}</h3>
                                                <p>When: Week starting on {{Carbon\Carbon::createFromFormat('Y-m-d',$reminder->occasion->due_date)->addWeeks(2)->format('d.m.Y')}}</p>
                                                <a href="{{route('ca.reminders.show', $reminder->id)}}" class="btn btn-success btn-block">Check the surprises</a>
                                                <p><small>Don't forget to provide feedback. Thank you!</small></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>

                            </div>
                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    @foreach($upcoming_reminders as $reminder)
                                        <div class="col-sm-6 col-md-3">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3>{{$reminder->occasion->client->name}}'s {{$reminder->occasion->type}}</h3>
                                                    <p>When: Week starting on {{Carbon\Carbon::createFromFormat('Y-m-d',$reminder->occasion->due_date)->addWeeks(2)->format('d.m.Y')}}</p>
                                                    <div class="upcomming-text">Coming soon</div>
                                                    <p><small>Reminder visible 2 weeks before occasion is due.</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3">
                                <div class="row">
                                    @foreach($expired_reminders as $reminder)
                                        <div class="col-sm-6 col-md-3">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3>{{$reminder->occasion->client->name}}'s {{$reminder->occasion->type}}</h3>
                                                    <p>When: Week starting on {{Carbon\Carbon::createFromFormat('Y-m-d',$reminder->occasion->due_date)->addWeeks(2)->format('d.m.Y')}}</p>
                                                    <a href="{{route('ca.reminders.show', $reminder->id)}}" class="btn btn-success btn-block">Expired</a>
                                                    {{--<p><small>Reminder visible 2 weeks before occasion is due.</small></p>--}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('javascript')


@endsection

@section('stylesheets')

    <style>
        .upcomming-text{
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            transition: box-shadow .28s cubic-bezier(.4,0,.2,1);
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            -ms-border-radius: 2px;
            -o-border-radius: 2px;
            border-radius: 2px;
            overflow: hidden;
            position: relative;
            user-select: none;
            padding: 8px 14px 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.18);
            line-height: 1.44;
            outline: 0!important;
            display: block;
            width: 100%;
            color: #fff;
            background-color: #36c6d3;
            border-color: #2bb8c4;
            text-align: center;
        }
    </style>

@endsection