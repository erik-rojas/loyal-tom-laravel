@extends('admin.main')

@section('title', 'All Ideas')

@section('content')

    <div class="page-content">
        <h1 class="page-title"> Search results<small> </small></h1>
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
                    <span>Search Results</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="page-bar">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                <!-- BEGIN HEADER SEARCH BOX -->
                {!! Form::open(['route' => 'ideas.search', 'method'=>'post']) !!}
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." name="q" value="{{isset($search)?$search:''}}">
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
            <div class="col-md-12">
                @if(isset($ideas) && $ideas->count() > 0)
                @foreach($ideas as $idea)
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
                @else
                    <div class="alert alert-warning" role="alert">No Results Found!</div>
                @endif
            </div>
        </div>

    </div>
@endsection

@section('javascript')

    <script src="{{ asset('js/select2.full.js')}}"></script>
    <script type="text/javascript">
        //Select2
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
    </style>

@endsection