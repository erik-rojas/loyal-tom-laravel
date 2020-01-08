<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{route('home')}}" style="color: #fff;line-height: 64px;">
                <img src="/img/02-LoyalTom_blue.svg" width="40" height="40">
            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <div class="page-actions">
            <div class="btn-group">
                <a href="{{route('ca.add')}}" class="btn btn-circle btn-outline red dropdown-toggle" style="margin-right: 5px;">
                    <i class="fa fa-plus hidden-xs"></i>&nbsp;
                    Add Client
                </a>
                <a href="{{route('ca.occasion')}}" class="btn btn-circle btn-outline red dropdown-toggle">
                    <i class="fa fa-plus hidden-xs"></i>&nbsp;
                    Add Occasion
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
                    <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            Help?
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default" style="width: 215px;">
                            <li>
                                <a href="tel:+41445018300"> Tel. +41 44 501 83 00</a>

                            </li>
                            <li>
                                <a href="mailto:welcome@loyaltom.com">
                                    welcome@loyaltom.com
                                </a>
                            </li>
                           <!--  <li>
                                <a href="">
                                    How does it work?
                                </a>
                            </li> -->
                        </ul>
                    </li>
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            <span class="badge badge-default"> {{Notifications::getReminders()->count()}} </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>
                                    <span class="bold">{{Notifications::getReminders()->count()}} last</span> notifications</h3>
                                <a href="{{route('ca.reminders.index')}}">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    @foreach(Notifications::getReminders() as $reminder)
                                        <li>
                                            <a href="{{route('ca.reminders.show', $reminder->id)}}">
                                                <span class="time">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $reminder->updated_at)->diffForHumans()}}</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-user"></i>
                                                    </span> New Reminder: {{$reminder->occasion->client->name}}'s {{$reminder->occasion->type}}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->

                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="/img/avatar_male.png" />
                            <span class="username username-hide-on-mobile"> {{Auth::user()->name}} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{route('ca.account')}}">
                                    <i class="icon-user"></i> Account settings  </a>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-log-out"> </span> Logout
                                </a>

                            </li>
                        </ul>
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
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->


<style>
    .page-header.navbar .top-menu .navbar-nav>li.dropdown-extended .dropdown-menu{
        max-width:350px;
        width:350px;
    }
    .page-header.navbar .top-menu .navbar-nav>li.dropdown-notification .dropdown-menu .dropdown-menu-list>li a .time{
        max-width:85px;
    }
</style>
