<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{route('home')}}" style="color: #fff;line-height: 64px;">
                <img src="/img/02-LoyalTom_blue.svg" width="40" height="40">
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <div class="page-actions">
            <div class="btn-group">
                <a class="btn btn-circle btn-outline red" href="{{route('reminders.index')}}">
                    <i class="fa fa-plus"></i>
                    <span class="hidden-xs">Create</span> Reminder
                </a>
                <a class="btn btn-circle btn-outline red" href="{{route('ideas.create')}}" style="margin-left:10px;">
                    <i class="fa fa-plus"></i>
                    <span class="hidden-xs">Add</span> New Idea
                </a>
            </div>
        </div>
        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            <span class="badge badge-default"> {{Notifications::getLatest()->count()}} </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>
                                    <span class="bold">{{Notifications::getLatest()->count()}} last</span> notifications</h3>
                                <a href="{{route('notifications.index')}}">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    @foreach(Notifications::getLatest() as $notification)
                                        @if($notification->type == 'client' && isset($notification->client->clientAdvisor->name))
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans()}}</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="fa fa-user"></i>
                                                        </span> New client added by {{$notification->client->clientAdvisor->name}} {{$notification->client->clientAdvisor->surname}}
                                                    </span>
                                                </a>
                                            </li>
                                        @elseif($notification->type == 'occasion' && isset($notification->occasion->client->clientAdvisor->name))
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans()}}</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="icon-diamond"></i>
                                                        </span> New occasion added by {{$notification->occasion->client->clientAdvisor->name}} {{$notification->occasion->client->clientAdvisor->surname}}
                                                    </span>
                                                </a>
                                            </li>
                                        @elseif($notification->type == 'feedback' && isset($notification->feedback->client->clientAdvisor->name))
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->diffForHumans()}}</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="fa fa-comment"></i>
                                                        </span> New feedback provided by {{$notification->feedback->client->clientAdvisor->name}} {{$notification->feedback->client->clientAdvisor->surname}}
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->

                    <!-- BEGIN TODO DROPDOWN -->
                    @if(isset($reminder))
                    <li class="dropdown dropdown-extended dropdown-inbox" id="header_task_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-docs"></i>
                            <span id="reminder-ideas-count" class="badge badge-default reminder-ideas-count">{{isset($reminder->ideas)?$reminder->ideas->count():0}}</span>
                        </a>

                        <ul class="dropdown-menu extended tasks">
                            <li class="external">
                                <h3>This Reminder has <span class="bold reminder-ideas-count">{{isset($reminder->ideas)?$reminder->ideas->count():0}}</span> ideas</h3>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller ideas-draft" style="height: 250px;" data-handle-color="#637283">
                                    @if(isset($reminder->ideas))
                                        @foreach($reminder->ideas as $idea)
                                            <li class="header-idea-{{$idea->id}}">
                                                <a href="{{route('reminders.idea.show', [$occasion->id, $idea->id])}}">
                                                    <span class="">
                                                        <img src="/upload/ideas/images/{{$idea->image}}" alt="" style="width:40px;float:left;">
                                                    </span>
                                                    <span class="subject">
                                                        <span class="from">{!! mb_substr(strip_tags($idea->headline), 0, 25) !!}{{ strlen(strip_tags($idea->headline)) > 25 ? "..." : "" }}</span>
                                                    </span>
                                                    <span class="message">
                                                        {!! mb_substr(strip_tags($idea->description), 0, 65) !!}{{ strlen(strip_tags($idea->description)) > 65 ? "..." : "" }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <li><a>No Ideas to this Reminder.</a></li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-close-others="true" id="no-hover">
                            <img alt="" class="img-circle" src="/img/avatar_male.png" />
                            <span class="username username-hide-on-mobile"> {{Auth::user()->name}} </span>
                            <i class="fa fa-angle-down" style="visibility: hidden;"></i>
                        </a>

                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended quick-sidebar-toggler">
                        <span class="sr-only" >Toggle Quick Sidebar</span>
                        <i class="icon-logout" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"></i>
                    </li>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<div class="clearfix"> </div>
<style>
    .page-header.navbar .top-menu .navbar-nav>li.dropdown-extended .dropdown-menu{
        max-width:365px;
        width:365px;
    }
    .page-header.navbar .top-menu .navbar-nav>li.dropdown-notification .dropdown-menu .dropdown-menu-list>li a .time{
        max-width:85px;
    }
    a#no-hover:hover{
        cursor:default;
        background: #fff;
    }
    .page-actions a{
        font-size:0.9em;
        padding:3px;
    }
</style>