<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start {{ Request::is('home') ? 'active open' : '' }}">
                <a href="{{route('home')}}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>
            </li>
            <!--Start Reminders Sidebar-->
            <li class="nav-item  {{ Request::is('admin/reminders*') ? 'active open' : '' }}">
                <a href="{{route('reminders.index')}}" class="nav-link">
                    <i class="icon-docs"></i>
                    <span class="title">Reminders</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--End Reminders Sidebar-->
            <!--Start Idea Sidebar-->
            <li class="nav-item  {{ Request::is('admin/ideas*') ? 'active open' : '' }}">
                <a href="{{route('ideas.index')}}" class="nav-link">
                    <i class="fa fa-gift"></i>
                    <span class="title">Ideas</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--End Idea Sidebar-->
            <!--Start user management -->
            <li class="nav-item ">
                <a href="{{route('admin.invite')}}" class="nav-link">
                    <i class="fa icon-user"></i>
                    <span class="title">User Management</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--Start Payment Sidebar-->
            <li class="nav-item  {{ Request::is('admin/payments*') ? 'active open' : '' }}">
                <a href="{{route('payments.index')}}" class="nav-link">
                    <i class="fa fa-usd"></i>
                    <span class="title">Payments</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--End Payment Sidebar-->

            <!--Start SETTINGS-->
            <li class="nav-item  {{ Request::is('admin/settings*') ? 'active open' : '' }}">
                <a href="{{route('exchange-rate.edit')}}" class="nav-link nav-toggle">
                    <i class="fa icon-settings"></i>
                    <span class="title">Settings</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--End SETTINGS-->

            <!--Start TAGS-->
            <li class="nav-item  {{ Request::is('admin/tags*') ? 'active open' : '' }}">
                <a href="{{route('tags.index')}}" class="nav-link nav-toggle">
                    <i class="fa icon-tag"></i>
                    <span class="title">Tags</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!--End TAGS-->

            <!-- START ANALITICS -->
            <li class="nav-item {{ Request::is('admin/analytics*') ? 'active open' : '' }}">
                <a href="{{route('analytics.index')}}" class="nav-link nav-toggle">
                    <i class="fa icon-bar-chart"></i>
                    <span class="title">Analytics</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!-- END ANALITICS -->

            <!-- START FEEDBACKS -->
            <li class="nav-item {{ Request::is('admin/feedback*') ? 'active open' : '' }}">
                <a href="{{route('feedback.index')}}" class="nav-link nav-toggle">
                    <i class="fa fa-comments"></i>
                    <span class="title">Feedback</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <!-- END FEEDBACKS -->

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>