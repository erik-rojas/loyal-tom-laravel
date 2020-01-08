@extends('admin.main')

@section('title', 'All Ideas')

@section('content')

    <div class="page-content">
        <h1 class="page-title"> All Ideas<small> </small></h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>All Ideas</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="page-bar">
            <div class="col-md-9">
                {!! Form::open(['route' => 'ideas.filter', 'method'=>'post']) !!}
                <div class="form-inline">
                    <label>Filter by Tags:</label>
                    <select name="tags[]" class="form-control select2" multiple>
                        @foreach($tags as $tag)
                            @if($selected_tags)
                                <option value="{{$tag->id}}" {{in_array($tag->id, $selected_tags)?'selected':''}}>{{$tag->name}}</option>
                            @else
                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                            @endif

                        @endforeach
                    </select>
                    <label> Order by:</label>
                    <select name="status" class="form-control">
                        <option value="I LIKE THIS IDEA" {{$status == 'I LIKE THIS IDEA'?'selected':''}}>Like</option>
                        <option value="Don't show me this idea any more" {{$status == 'Don\'t show me this idea any more'?'selected':''}}>Dislike</option>
                        <option value="Don’t show this idea for this client" {{$status == 'Don’t show this idea for this client'?'selected':''}}>Don't show for client</option>
                        <option value="I purchased this idea" {{$status == 'I purchased this idea'?'selected':''}}>Bought </option>
                    </select>
                    <button type="submit" class="btn submit">
                        Filter
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-3">
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
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @foreach($ideas as $idea)
                    {{--finally got the feedbacks for idea in array--}}

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="portlet light portlet-fit ">
                            <div class="portlet-body">
                                <div class="mt-element-overlay">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mt-overlay-5">
                                                <img src="/upload/ideas/images/{{$idea->image}}" />
                                                <div class="mt-overlay">
                                                    <h2>{!! mb_substr(strip_tags($idea->headline), 0, 30) !!}{{ strlen(strip_tags($idea->headline)) > 30 ? "..." : "" }}</h2>
                                                    <span style="color: #fff;"><i class="fa fa-thumbs-o-up"></i> {{$idea->feedbacks->where('status', 'I LIKE THIS IDEA')->count()}}</span>
                                                    <span style="color: #fff;"><i class="fa fa-thumbs-o-down"></i> {{$idea->feedbacks->where('status', "Don't show me this idea any more")->count()}}</span>
                                                    <span style="color: #fff;">&#8764;{{$idea->feedbacks->where('status', 'Don’t show this idea for this client')->count()}}</span>
                                                    <span style="color: #fff;"><i class="fa fa-money"></i> {{$idea->feedbacks->where('status', 'I purchased this idea')->count()}}</span>
                                                    <p>
                                                        <a class="uppercase" href="{{route('ideas.show', $idea->id)}}">Learn More</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {!! $ideas->links() !!}
            </div>
        </div>

    </div>
@endsection

@section('javascript')

    <script src="{{ asset('js/select2.full.js')}}"></script>

    <script type="text/javascript">
        //Select2 for Filter by Tags
        $('.select2').select2();
    </script>

@endsection

@section('stylesheets')

    {!! Html::style('css/select2.min.css') !!}
    <style>
        .select2{
            min-width: 50%;
            max-width: 75%;
        }
        .mt-overlay-5{
            text-shadow:1px 1px 1px #000;
        }
        .mt-overlay-5 .mt-overlay h2, .mt-overlay h2{
            margin-top:0px;
            padding-top:0px;
        }
        .mt-overlay h2{
            font-weight: 600;
        }
    </style>

@endsection