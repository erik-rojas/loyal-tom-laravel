@extends('client.main')

@section('title', $reminder->occasion->type)

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <h1 class="page-title"> Reminder - {{$reminder->occasion->type}}</h1>
            <!-- BREADCRUMBS-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{route('home')}}">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="{{route('ca.reminders.index')}}">Reminders</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>{{$reminder->occasion->client->name}}'s {{$reminder->occasion->type}}</span>
                    </li>
                </ul>
            </div>
            <!-- END BREADCRUMBS-->
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif

            <div class="row">
                <div class="idea-container col-md-8 col-md-offset-2">

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
                        <h2 class="idea-title">{{$idea->headline}}</h2>
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

                            <div class="idea-price">Price: {{$idea->price + ($idea->additional_price*$idea->currency->rate)}} {{$idea->currency->name}}</div>

                            <div class="row">
                                <!------- Temporary -------->
                                <div class="col-md-12">
                                    <form id="paymentForm-{{$idea->id}}"
                                          data-merchant-id="3000012164"
                                          data-amount="{{($idea->price*$idea->currency->rate*100) + ($idea->additional_price*100)}}"
                                          {{--data-currency="{{$idea->currency->name}}"--}}
                                          data-currency="CHF"
                                          data-paymentmethod="VIS,ECA,TWI"
                                          data-language="en"
                                          data-refno="123456789"
                                          data-sign="1499248356719"
                                          data-_token="{{csrf_token()}}"
                                          data-idea_id="{{$idea->id}}"
                                          data-success-Url ="{{route('ca.payment', $reminder->id)}}"
                                          data-cancel-Url ="{{route('ca.payment', $reminder->id)}}"
                                          data-error-Url ="{{route('ca.payment', $reminder->id)}}"
                                            {{--data-theme-configuration="{'brandColor': '#01BD32','textColor': 'white','logoType': 'circle','logoBorderColor': '#000000','brandButton': 'true','logoSrc': 'merchant-logo.svg'}"--}}
                                    >
                                        <button id="paymentButton-{{$idea->id}}" style="border: none;width: 100%;" class="btn-buy" data-idea-id="{{$idea->id}}" data-reminder-id="{{$reminder->id}}" data-type="buy_for_me">{{$idea->button_buy_for_me_text}}</button>
                                    </form>
                                    <div class="checkbox checkbox-terms" id="checkbox-terms-{{$idea->id}}">
                                        <label>
                                            <input type="checkbox" id="checkbox-{{$idea->id}}">
                                            Accept <a href="http://surpriseclub.ch/assets/SurpriseClubTermsandConditions.pdf" target="_blank">terms and conditions</a>
                                        </label>
                                    </div>
                                </div>
                                <!-------END Temporary -------->
                                @if(false && ($idea->price*$idea->currency->rate + $idea->additional_price) <= 200)

                                    <div class="col-md-6">
                                        <a href="{{url($idea->url)}}" class="btn-buy" data-idea-id="{{$idea->id}}" data-reminder-id="{{$reminder->id}}" data-type="buy" target="_blank">{{$idea->button_buy_text}}</a>
                                    </div>
                                    <div class="col-md-6">
                                        {{--Stripe don't use anymore--}}
                                        {{--{!! Form::open(['route' => ['pay'], 'method'=>'post', 'class' => 'stripe']) !!}--}}
                                        {{--<input type="hidden" name="description" value="{{$idea->headline}}">--}}
                                        {{--<input type="hidden" name="amount" value="{{($idea->price * 100) + ($idea->additional_price * 100)}}">--}}
                                        {{--<input type="hidden" name="currency" value="{{$idea->currency->name}}">--}}
                                        {{--<script--}}
                                        {{--src="https://checkout.stripe.com/checkout.js" class="stripe-button"--}}
                                        {{--data-key="pk_test_fu2FHepvOzHsgWwZY70ZGL50"--}}
                                        {{--data-amount='{{($idea->price * 100) + ($idea->additional_price * 100)}}'--}}
                                        {{--data-name="LOYALTOM/SURPRISECLUB"--}}
                                        {{--data-description="{{$idea->headline}}"--}}
                                        {{--data-label="{{$idea->button_buy_for_me_text}}"--}}
                                        {{--data-email="{{Auth::user()->email}}"--}}
                                        {{--data-image="https://s3.amazonaws.com/stripe-uploads/acct_18M1ZkLfwEco1LMfmerchant-icon-1495099491024-loyaltom_logo_bw.jpg"--}}
                                        {{--data-locale="auto"--}}
                                        {{--data-token={{ csrf_token() }}--}}
                                        {{--data-zip-code="true"--}}
                                        {{--data-currency="{{$idea->currency->name}}">--}}
                                        {{--</script>--}}
                                        {{--<script>--}}
                                        {{--document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';--}}
                                        {{--document.getElementsByClassName("stripe-button-el")[1].style.display = 'none';--}}
                                        {{--document.getElementsByClassName("stripe-button-el")[2].style.display = 'none';--}}
                                        {{--</script>--}}
                                        {{--<button type="submit" style="border: none;width: 100%;"class="btn-buy" data-idea-id="{{$idea->id}}" data-reminder-id="{{$reminder->id}}" data-type="buy_for_me">{{$idea->button_buy_for_me_text}}</button>--}}
                                        {{--{!! Form::close() !!}--}}

                                        {{--www.datatrans.ch--}}

                                        <form id="paymentForm-{{$idea->id}}"
                                              data-merchant-id="3000012164"
                                              data-amount="{{($idea->price*$idea->currency->rate*100) + ($idea->additional_price*100)}}"
                                              {{--data-currency="{{$idea->currency->name}}"--}}
                                              data-currency="CHF"
                                              data-paymentmethod="VIS,ECA,TWI"
                                              data-language="en"
                                              data-refno="123456789"
                                              data-sign="1499248356719"
                                              data-_token="{{csrf_token()}}"
                                              data-idea_id="{{$idea->id}}"
                                              data-success-Url ="{{route('ca.payment', $reminder->id)}}"
                                              data-cancel-Url ="{{route('ca.payment', $reminder->id)}}"
                                              data-error-Url ="{{route('ca.payment', $reminder->id)}}"
                                                {{--data-theme-configuration="{'brandColor': '#01BD32','textColor': 'white','logoType': 'circle','logoBorderColor': '#000000','brandButton': 'true','logoSrc': 'merchant-logo.svg'}"--}}
                                        >
                                            <button id="paymentButton-{{$idea->id}}" style="border: none;width: 100%;" class="btn-buy" data-idea-id="{{$idea->id}}" data-reminder-id="{{$reminder->id}}" data-type="buy_for_me">{{$idea->button_buy_for_me_text}}</button>
                                        </form>
                                        <div class="checkbox checkbox-terms" id="checkbox-terms-{{$idea->id}}">
                                            <label>
                                                <input type="checkbox" id="checkbox-{{$idea->id}}">
                                                Accept <a href="http://surpriseclub.ch/assets/SurpriseClubTermsandConditions.pdf" target="_blank">terms and conditions</a>
                                            </label>
                                        </div>


                                    </div>
                                @elseif(false)
                                    <div class="col-md-12">
                                        <a href="{{url($idea->url)}}" class="btn-buy" data-idea-id="{{$idea->id}}" data-reminder-id="{{$reminder->id}}" data-type="buy" target="_blank">{{$idea->button_buy_text}}</a>
                                    </div>

                                @endif
                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="dropdown">
                                        <button class="btn btn-default btn-block dropdown-toggle btn-circle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            HELP US IMPROVE YOUR GIFTS
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="width:100%;">
                                            <li>
                                                <a class="feedbackItem" data-feedback="{{$idea->id}}">I LIKE THIS IDEA</a>
                                            </li>
                                            <li>
                                                <a class="feedbackItem" data-feedback="{{$idea->id}}">I purchased this idea</a>
                                            </li>
                                            <li>
                                                <a class="feedbackItem" data-feedback="{{$idea->id}}">Don’t show this idea for this client</a>
                                            </li>
                                            <li>
                                                <a class="feedbackItem" data-feedback="{{$idea->id}}">Don't show me this idea any more</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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
                                and entrepreneurs from <a href="http://loyaltom.com" style="color: #000000;        text-decoration: underline;">LOYALTOM.COM</a>.
                                Feel free to send any feedback to <a href="mailto:welcome@surpriseclub.ch?Subject=Hello%20from%20Email%20reminder" target="_top" style="color: #000000;        text-decoration: underline;"> welcome@surpriseclub.ch</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="modal_success" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thank you!</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="modal_terms" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Terms & Conditions</h4>
                </div>
                <div class="modal-body">
                    Please accept <a href="http://surpriseclub.ch/assets/SurpriseClubTermsandConditions.pdf" target="_blank">terms and conditions</a>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

        $('.dropdown-toggle').dropdown();

        $('.feedbackItem').click(function(e){
            e.preventDefault();
            var ideaId = $(this).data('feedback');
            var status = $(this).text();
            var clientId = {{$reminder->occasion->client_id}};
            $.ajax({
                url:'{{route('ca.feedback.store')}}',
                type: "POST",
                data: {
                    "_token": window.Laravel["csrfToken"],
                    "ideaId": ideaId,
                    "status": status,
                    "clientId": clientId,
                },
                success: function(data) {
                    if (data.error) {
                        $('#modal_error').modal('show');
                        jQuery('#modal_error .modal-body').html(data.error);
                    } else {
                        jQuery('#modal_success .modal-body').html(data.success);
                        $('#modal_success').modal('show');
                        jQuery(e.target).replaceWith('<span>'+ jQuery(e.target).html()+'</span>');
                        console.log(e.target);
                    }
                }
            });
        });

        //Click Counter
        $('.btn-buy').on('click', function(event){
            var idea_id = $(this).attr('data-idea-id');
            var reminder_id = $(this).attr('data-reminder-id');
            var type = $(this).attr('data-type');
            if(($('#checkbox-'+idea_id+':checked').length > 0) || type == 'buy'){
                var url = "{{route('ca.clicks.create')}}";
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {idea_id:idea_id, reminder_id:reminder_id, type:type,  _token:token},
                    success: function(data) {
                        console.log(data);
                    }
                });
            }else{
                $('#modal_terms').modal('show');
                $('#checkbox-terms-'+idea_id+' label').addClass('terms-red');
                event.stopImmediatePropagation();
                event.preventDefault();
            }

        });

    </script>


    //Datatrans
    <script src="https://payment.datatrans.biz/upp/payment/js/datatrans-1.0.2.js"></script>
    <script type="text/javascript">
        @foreach($reminder->ideas as $idea)
        $("#paymentButton-{{$idea->id}}").click(function () {
            slider1.stopAuto();
            slider2.stopAuto();
            slider3.stopAuto();
            Datatrans.startPayment({'form': '#paymentForm-{{$idea->id}}'});
        });
        @endforeach
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

        .checkbox-terms{
            margin-top:5px;
            margin-left:20px;
            text-align: center;
        }
        .terms-red, .terms-red a{
            color:#f00;
        }

        .feedbackItem{
            color: #a52c2f;
            text-decoration: underline;
        }


        @media screen and (max-width:640px){
            .idea-header{
                padding: 25px 0px 0px;
            }
            .idea-header-img{
                float:none;
                width:75px;
                margin:0 auto;
            }
            .idea-header-img img{
                width:75px;
            }
            .idea-header-title{
                width:100%;
                margin-left:0;
            }
            .idea-header-title h1{
                text-align: center;
                font-size: 24px;
            }
            h2.header-hello-title{
                font-size: 24px;
            }
            .idea-main-content{
                padding: 0;
            }
            h2.idea-title{
                font-size: 24px;
            }
            .idea-footer{
                padding: 30px 20px;
            }
            .footer-img{
                width:80px;
            }

        }
    </style>

@endsection