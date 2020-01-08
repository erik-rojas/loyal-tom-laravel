@extends('admin.main')

@section('title', 'Preview Reminder')

@section('content')

    <div class="page-content">
        <h1 class="page-title">Preview</h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="{{route('reminders.index')}}">All Reminders</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Preview</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="row">
            <div class="idea-container col-md-8">

                <div class="idea-header">
                    <div class="idea-header-img">
                        <img src="/img/SurpriseClub_logo.jpeg" alt="LoyalTom Logo"/>
                    </div>
                    <div class="idea-header-title">
                        <h1>
                            Connect with your clients on a deeper level.
                        </h1>
                    </div>
                </div>

                <div class="idea-main-content">
                    <h2 class="header-hello-title"><strong>Dear {{$reminder->occasion->client->clientAdvisor->user->name}},</strong></h2>
                    <p class="header-hello-text">
                        In a week starting on {{Carbon\Carbon::createFromFormat('Y-m-d',$reminder->occasion->due_date)->addWeeks(2)->format('d.m.Y')}}, it's {{$reminder->occasion->client->name}}'s {{$reminder->occasion->type}}.<br/>
                        Surprise your client with these great gifts.<br/><br/>
                    </p>
                </div>

                @foreach($reminder->ideas as $idea)
                    <h2>{{$idea->headline}}</h2>
                    <p class="idea-address">{{$idea->address}}</p>

                    <ul class="bxslider{{$loop->iteration}}">
                        <li><img src="/upload/ideas/images/{{$idea->image}}" style="width:100%;"></li>
                        @forelse ($idea->ideaImages as $image)
                            <li><img src="/upload/ideas/images/{{$image->name}}" style="width:100%;"></li>
                        @empty
                        @endforelse
                        @if($idea->video != null)
                            <li>
                                <iframe width="640" height="430" src="{{$idea->video}}" frameborder="0" allowfullscreen></iframe>
                            </li>
                        @endif
                    </ul>

                    <div class="idea-main-content">
                        {!! $idea->description !!}

                        @if($idea->dates->count())
                            <h5>Dates:</h5>
                            <ul>
                                @foreach($idea->dates as $date)
                                    <li>{{Carbon\Carbon::createFromFormat('Y-m-d', $date->date)->format('d.m.Y')}}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="idea-price">Price: {{$idea->price}} {{$idea->currency->name}}</div>

                        <div class="row">
                            @if(($idea->price*$idea->currency->rate + $idea->additional_price) <= 200)

                                <div class="col-md-6">
                                    <a href="{{$idea->url}}" class="btn-buy" target="_blank">{{$idea->button_buy_text}}</a>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn-buy">{{$idea->button_buy_for_me_text}}</a>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <a href="{{$idea->url}}" class="btn-buy" target="_blank">{{$idea->button_buy_text}}</a>
                                </div>
                            @endif
                        </div>

                    </div>
                    <hr />
                @endforeach

                <div class="idea-footer">
                    <div class="footer-img">
                        <img src="/img/SurpriseClub_surprise.jpeg" alt="footer image"/>
                    </div>
                    <div class="footer-text">
                        <p>UBS LoyalTom is a life event service that helps you to show appreciation to your clients by surprising them with thoughtful gifts on special occasions.</p>
                        <p>
                            It is a pilot project created by UBS intrapreneurs
                            and entrepreneurs from <a href="http://loyaltom.com" style="color: #000000;        text-decoration: underline;">
                                LOYALTOM.COM</a>.
                            Feel free to send any feedback to <a href="mailto:welcome@surpriseclub.ch?Subject=Hello%20from%20Email%20reminder" target="_top" style="color: #000000;        text-decoration: underline;">
                                welcome@surpriseclub.ch</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="portlet green-sharp box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-docs"></i>Reminder Actions
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td><strong>Reminder Status</strong></td>
                                <td>{{$reminder->status}}</td>
                            </tr>
                            <tr>
                                <td><strong>SMS sent</strong></td>
                                <td>{!! $reminder->sms_sent?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove">'!!}</td>
                            </tr>
                            <tr>
                                <td><strong>Email sent</strong></td>
                                <td>{!! $reminder->email_sent?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove">' !!}</td>
                            </tr>
                            </tbody>
                        </table>
                        <hr />
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::open(['route' => ['reminders.send-sms'], 'method'=>'post']) !!}
                                <input type="hidden" name="reminder_id" value="{{$reminder->id}}">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <span class="glyphicon glyphicon-phone"></span> Send SMS
                                </button>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::open(['route' => ['reminders.send-email'], 'method'=>'post']) !!}
                                <input type="hidden" name="reminder_id" value="{{$reminder->id}}">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <span class="glyphicon glyphicon-envelope"></span> Send email
                                </button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                @if($reminder->status != 'Scheduled')
                                <a href="{{route('reminders.schedule', $reminder->id)}}" class="btn btn-success btn-block">
                                    <span class="fa fa-clock-o"></span> Schedule
                                </a>
                                @elseif(!$reminder->email_sent && !$reminder->sms_sent)
                                    {!! Form::open(['route' => ['reminders.schedule-cancel'], 'method'=>'post']) !!}
                                    <input type="hidden" name="reminder_id" value="{{$reminder->id}}">
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <span class="fa fa-clock-o"></span> Cancel Scheduled
                                    </button>
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

    <script src="{{ asset('css/global/plugins/jquery.bxslider/jquery.bxslider.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery.bxslider/vendor/jquery.fitvids.js')}}" type="text/javascript"></script>

    <script type="text/javascript">

        slider1 = $('.bxslider1').bxSlider({
            auto: ($(".bxslider1 li").length > 1) ? true: false,
            pager: ($(".bxslider1 li").length > 1) ? true: false,
            touchEnabled: ($(".bxslider1 li").length > 1) ? true: false,
            pause:5000,
            controls:false,
            video: true,
            useCSS: false,
            onSlideAfter: function($slideElement, oldIndex, newIndex){
                //Stop video if goes to next slide
                if(oldIndex == slider1.getSlideCount()-1 && newIndex != slider1.getSlideCount()-1){
                    var iframes = document.getElementsByTagName("iframe");
                    if (iframes != null) {
                        for (var i = 0; i < iframes.length; i++) {
                            iframes[i].src = iframes[i].src; //causes a reload so it stops playing, music, video, etc.
                        }
                    }
                }
            }
        });

        slider2 = $('.bxslider2').bxSlider({
            auto: ($(".bxslider2 li").length > 1) ? true: false,
            pager: ($(".bxslider2 li").length > 1) ? true: false,
            touchEnabled: ($(".bxslider2 li").length > 1) ? true: false,
            pause:5000,
            controls:false,
            video: true,
            useCSS: false,
            onSlideAfter: function($slideElement, oldIndex, newIndex){
                //Stop video if goes to next slide
                if(oldIndex == slider2.getSlideCount()-1 && newIndex != slider2.getSlideCount()-1){
                    var iframes = document.getElementsByTagName("iframe");
                    if (iframes != null) {
                        for (var i = 0; i < iframes.length; i++) {
                            iframes[i].src = iframes[i].src; //causes a reload so it stops playing, music, video, etc.
                        }
                    }
                }
            }
        });

        slider3 = $('.bxslider3').bxSlider({
            auto: ($(".bxslider3 li").length > 1) ? true: false,
            pager: ($(".bxslider3 li").length > 1) ? true: false,
            touchEnabled: ($(".bxslider3 li").length > 1) ? true: false,
            pause:5000,
            controls:false,
            video: true,
            useCSS: false,
            onSlideAfter: function($slideElement, oldIndex, newIndex){
                //Stop video if goes to next slide
                if(oldIndex == slider3.getSlideCount()-1 && newIndex != slider3.getSlideCount()-1){
                    var iframes = document.getElementsByTagName("iframe");
                    if (iframes != null) {
                        for (var i = 0; i < iframes.length; i++) {
                            iframes[i].src = iframes[i].src; //causes a reload so it stops playing, music, video, etc.
                        }
                    }
                }
            }
        });

    </script>

@endsection

@section('stylesheets')

    <link href="{{ asset('css/global/plugins/jquery.bxslider/jquery.bxslider.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet" type="text/css">
    <style>
        .idea-container{
            background:#fff;
            font-family: Arial, Helvetica, sans-serif !important;
        }
        .idea-container h2{
            text-align: center;
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 34px;
        }
        .idea-header{
            padding:25px 50px
        }
        .idea-header-img{
            width:100px;
            float:left;
        }
        .idea-header-img img{
            width:100px;
        }
        .idea-header-title{
            width:100%;
            margin-left:100px;
            margin-right:25px;
        }
        .idea-header-title h1{
            margin:20px 25px;
            font-family: Helvetica;
            font-size: 24px;
            line-height: 28px;
            color: #101010;
            font-weight: normal;
            text-align: left;
        }
        .header-hello-title{
            color:#000;
        }
        .header-hello-text{
            text-align: center;
            line-height: 28px;
            color:#000;
            font-size: 17px;
        }
        .idea-address{
            color:#a52c2f;
            text-align: center;
            margin: 0px 0px 10px 0px;
            font-size: 12px;
            line-height: 50px;
        }
        .idea-main-content{
            padding:0 50px;
            color:#808080;
        }
        .idea-price{
            line-height:45px;
            font-size: 12px;
        }
        .btn-buy{
            display: block;
            margin-top:20px;
            padding: 10px 0px;
            background-color: #a52c2f;
            color: #fff;
            font-family: 'PT Sans', Sans-Serif;
            font-size: 17px;
            line-height: 23px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            font-weight: normal;
        }
        a.btn-buy:hover, a.btn-buy:active{
            color: #fff;
            text-decoration: none;
        }
        .label{
            display:inline-block;
            margin-top:4px;
        }
        .idea-footer{
            background:#ECF0F1;
            margin:-19px -20px -10px;
            padding:30px 70px;
            overflow: auto;
        }
        .footer-text{
            width:100%;
            margin-right:220px;
            color:#7F8C8D;
            font-size: 14px;
        }
        .footer-text p{
            line-height: 23px;
        }
        .footer-img{
            float:right;
            width: 160px;
        }
        .footer-img img{
            width:100%;
        }


        @media screen and (max-width:640px){
            .idea-header-img{
                float:none;
                width:100px;
                margin:0 auto;
            }
            .idea-header-img img{
                width:100px;
            }
            .idea-header-title{
                width:100%;
                margin-left:0;
            }
            .idea-header-title h1{
                text-align: center;
                font-size: 24px;
            }
        }
    </style>

@endsection