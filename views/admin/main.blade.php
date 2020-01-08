<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

@include('admin.partials._head')

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md">

<!-- BEGIN HEADER -->
    @include('admin.partials._header')
<!-- END HEADER -->

<!-- BEGIN CONTAINER -->
<div class="page-container">

    <!-- BEGIN SIDEBAR -->
        @include('admin.partials._sidebar')
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @yield('content')
    </div>
    <!-- END CONTENT -->

</div>
<!-- END CONTAINER -->


<!-- BEGIN FOOTER -->
    @include('admin.partials._footer')
    @include('admin.partials._javascript')
    @yield('javascript')
<!-- END FOOTER -->

<!-- MODAL NOTIFICATIONS -->
    @include ('admin.partials._modalNotification')
<!-- END MODAL NOTIFICATIONS -->

</body>

</html>