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
                    <i class="icon-home"></i>
                    <a href="{{route('ideas.index')}}">All Ideas</a>
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
                        <li id="li-video">
                            <iframe id="frame-1" width="640" height="430" src="{{$idea->video}}" frameborder="0" allowfullscreen></iframe>
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
                            <li>{!! Carbon\Carbon::createFromFormat('Y-m-d', $date->date)->format('d.m.Y')  !!}</li>
                        @endforeach
                        </ul>
                        <hr />

                        <h5><span class="glyphicon glyphicon-pencil"> </span> <strong>Created at:</strong></h5>
                        <div>{!! Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $idea->created_at)->format('H:i d.m.Y')  !!}</div>
                        <hr>

                        <h5><span class="glyphicon glyphicon-edit"> </span> <strong>Updated at:</strong></h5>
                        <div>{!! Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $idea->updated_at)->format('H:i d.m.Y')  !!}</div>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <a class="btn btn-primary btn-block" href="{{route('ideas.edit', $idea->id)}}">
                                    <span class="fa fa-edit"></span> Edit
                                </a>
                            </div>
                            <div class="col-md-6">
                                {{ Form::open(['route' => ['ideas.destroy', $idea->id], 'method' =>'DELETE']) }}
                                <button type="submit" class="btn btn-danger btn-block">
                                    <span class="fa fa-trash"></span> Delete
                                </button>
                                {{ Form::close() }}
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

        slider = $('.bxslider').bxSlider({
            auto: ($(".bxslider li").length > 1) ? true: false,
            pager: ($(".bxslider li").length > 1) ? true: false,
            touchEnabled: ($(".bxslider li").length > 1) ? true: false,
            pause:5000,
            controls:false,
            video: true,
            useCSS: false,
            onSlideAfter: function($slideElement, oldIndex, newIndex){
                //Stop video if goes to next slide
                if(oldIndex == slider.getSlideCount()-1 && newIndex != slider.getSlideCount()-1){
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