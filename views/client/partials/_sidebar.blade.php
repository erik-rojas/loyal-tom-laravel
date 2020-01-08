<div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start {{ Request::is('home') ? 'active open' : '' }}">
                <a href="/home" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>

            </li>

            <li class="nav-item  {{ Request::is('client-advisor/reminders*') ? 'active open' : '' }}">
                <a href="{{route('ca.reminders.index')}}" class="nav-link nav-toggle">
                    <i class="icon-docs"></i>
                    <span class="title">Reminders</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <li class="nav-item  {{ Request::is('client-advisor/occasion/*') ? 'active open' : '' }}">
                <a href="{{route('ca.occasion')}}" class="nav-link nav-toggle">
                    <i class="fa icon-users"></i>
                    <span class="title">Clients & Occasions</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <li class="nav-item  {{ Request::is('client-advisor/account') ? 'active open' : '' }}">
                <a href="{{route('ca.account')}}" class="nav-link nav-toggle">
                    <i class="fa icon-user"></i>
                    <span class="title">Account</span>
                    <span class="arrow"></span>
                </a>
            </li>

        </ul>
        <!-- END SIDEBAR MENU -->
    </div
    <!-- END SIDEBAR -->
</div>