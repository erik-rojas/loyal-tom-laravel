@extends('admin.main')

@section('title', $idea->headline)

@section('content')

    <div class="page-content">
        <h1 class="page-title"> {{$idea->headline}}<small> </small></h1>
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
                    <a href="{{route('reminders.create', $occasion->id)}}">New Reminder</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>{{$idea->headline}}</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="page-bar">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <!-- BEGIN HEADER SEARCH BOX -->
                <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
                {!! Form::open(['route' => 'ideas.search', 'method'=>'post']) !!}
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." name="q" required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn submit">
                            <i class="icon-magnifier"></i>
                        </button>
                    </span>
                </div>
            {!! Form::close() !!}
            <!-- END HEADER SEARCH BOX -->
            </div>
        </div>

        <div class="row">
            <div class="idea-container col-md-8">

                <h2>{{$idea->headline}}</h2>
                <p class="idea-address">{{$idea->address}}</p>

                <ul class="bxslider">
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

                    <div class="idea-price">{{$idea->price}} {{$idea->currency->name}}</div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{url($idea->url)}}" class="btn-buy" target="_blank">{{$idea->button_buy_text}}</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn-buy">{{$idea->button_buy_for_me_text}}</a>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-md-4">
                <div class="portlet green-sharp box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Idea Info
                        </div>
                    </div>
                    <div class="portlet-body">
                        <h5><span class="fa fa-tags"> </span> <strong>Tags:</strong></h5>
                        @foreach($idea->tags as $tag)
                            <span class="label label-default">{{$tag->name}}</span>
                        @endforeach
                        <hr />
                        <hr />
                        <h5><span class="fa fa-tags"> </span> <strong>Feedbacks:</strong></h5>
                        <i class="fa fa-thumbs-o-up"></i> I like this idea - {{count($likes)}}x
                        <br/>
                        <i class="fa fa-money"></i> I purchased this idea - {{count($purchases)}}x
                        <br>
                        &#8764; Don’t show this idea for this client - {{count($mismatch)}}x
                        <br>
                        <i class="fa fa-thumbs-o-down"></i> Don't show me this idea any more - {{count($dislikes)}}x
                        <hr />
                        <h5><span class="glyphicon glyphicon-time"> </span> <strong>Dates:</strong></h5>
                        <ul>
                            @foreach($idea->dates as $date)
                                <li>{{$date->date}}</li>
                            @endforeach
                        </ul>
                        <hr />

                        <h5><span class="glyphicon glyphicon-pencil"> </span> <strong>Created at:</strong></h5>
                        <div>{!! $idea->created_at !!}</div>
                        <hr>

                        <h5><span class="glyphicon glyphicon-edit"> </span> <strong>Updated at:</strong></h5>
                        <div>{!! $idea->updated_at !!}</div>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                @if($reminder->ideas()->find($idea->id))
                                    <button class="remove-reminder btn btn-success btn-block" data-idea-id="{{$idea->id}}">
                                        <span class="fa fa-remove"></span> Remove from Reminder
                                    </button>
                                @else
                                    <button class="add-reminder btn btn-success btn-block" data-idea-id="{{$idea->id}}">
                                        <span class="fa fa-plus"></span> Add to Reminder
                                    </button>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('reminders.create', $occasion->id)}}" class="btn btn-default btn-block">
                                    <span class="fa fa-arrow-left"></span> Back to all Ideas
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Notifications -->
    <div id="modal_success" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <div>Idea was added successfully to the Reminder!</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="modal_success_deleted" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <div>Idea was deleted successfully from the Reminder!</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="modal_warning" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Warning!</h4>
                </div>
                <div class="modal-body">
                    <div>You already have 3 ideas to this reminder!</div>
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

        $('.bxslider').bxSlider({
            auto: ($(".bxslider li").length > 1) ? true: false,
            pager: ($(".bxslider li").length > 1) ? true: false,
            touchEnabled: ($(".bxslider li").length > 1) ? true: false,
            pause:5000,
            controls:false,
            video: true,
            useCSS: false
        });


        //Add idea to reminder
        $(document).on('click', '.add-reminder', function(){

            //Check number of added ideas
            if(Number($('#reminder-ideas-count').text()) < 3){
                var reminder_ides_count = Number($('#reminder-ideas-count').text()) + 1;
                $('.reminder-ideas-count').text(reminder_ides_count);
                $(this).parents('.portlet-body').addClass('idea-selected');
                $(this).addClass('remove-reminder').removeClass('add-reminder').html('<span class="fa fa-remove"></span> Remove from Reminder');

                var idea_id = $(this).attr('data-idea-id');
                var occasion_id = {{$occasion->id}};
                var token = "{{ csrf_token() }}";
                var url = "{{route('reminders.add-idea')}}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {idea_id:idea_id, occasion_id:occasion_id, _token:token},
                    success: function(data) {
                        console.log(data);
                        $('.ideas-draft').append('' +
                            '<li class="header-idea-'+data.id+'">' +
                            '<a href="/admin/reminders/{{$occasion->id}}/'+data.id+'">' +
                            '<span class="">' +
                            '<img src="/upload/ideas/images/'+data.image+'" alt="" style="width:40px;float:left;">' +
                            '</span>' +
                            '<span class="subject">' +
                            '<span class="from">'+data.headline+'</span>' +
                            '</span>' +
                            '<span class="message">' +data.description.replace(/<\/?[^>]+(>|$)/g, "").substring(0,60)+'...'+
                            '</span>' +
                            '</a>' +
                            '</li>');

                        $('#modal_success').modal('show');
                    }
                });
            }
            else{
                $('#modal_warning').modal('show');
            }

        });


        $(document).on('click', '.remove-reminder', function(){
            var reminder_ides_count = Number($('#reminder-ideas-count').text()) - 1;
            $('.reminder-ideas-count').text(reminder_ides_count);
            $(this).parents('.portlet-body').removeClass('idea-selected');
            $(this).removeClass('remove-reminder').addClass('add-reminder').html('<span class="fa fa-plus"></span> Add to Reminder');
            var idea_id = $(this).attr('data-idea-id');
            $('.header-idea-'+idea_id).remove();
            var reminder_id = {{$reminder->id}};
            var token = "{{ csrf_token() }}";
            var url = "{{route('reminders.remove-idea')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {idea_id:idea_id, reminder_id:reminder_id, _token:token},
                success: function(data) {
                    console.log(data);
                    $('#modal_success_deleted').modal('show');
                }
            });
        });

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

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
    </style>

@endsection