@extends('admin.main')

@section('title', 'All Notifications')

@section('content')

    <div class="page-content">
        <h1 class="page-title">All Notifications</h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>All Notifications</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="row">
            <div class="col-md-6">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-globe font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">Notifications</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <ul class="feeds">
                    @foreach($notifications as $notification)
                        @if($notification->type == 'client')
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> New client added by {{isset($notification->client->clientAdvisor->name)?$notification->client->clientAdvisor->name:'Client Deleted'}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans()}} </div>
                                </div>
                            </li>
                        @elseif($notification->type == 'occasion')
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">
                                                <i class="icon-diamond"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> New occasion added by {{isset($notification->occasion->client->clientAdvisor->name)?$notification->occasion->client->clientAdvisor->name:'Occasion deleted'}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans()}} </div>
                                </div>
                            </li>
                        @elseif($notification->type == 'feedback')
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">
                                                <i class="fa fa-comment"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> New feedback provided by {{isset($notification->feedback->client->clientAdvisor->name)?$notification->feedback->client->clientAdvisor->name:'User Deleted'}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans()}} </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                        {!! $notifications->links() !!}
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
        .date{
            width:120px;
            min-width:120px;
            float:right;
        }
    </style>


@endsection