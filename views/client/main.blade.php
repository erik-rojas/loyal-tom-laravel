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

@include('client.partials._head')

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md">

<!-- BEGIN HEADER -->
    @include('client.partials._header')
<!-- END HEADER -->

<!-- BEGIN CONTAINER -->
<div class="page-container">

    <!-- BEGIN SIDEBAR -->
        @include('client.partials._sidebar')
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
        @yield('content')
    <!-- END CONTENT -->

</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
    @include('client.partials._footer')
    @include('client.partials._javascript')
    @yield('javascript')
<!-- END FOOTER -->



@if (Session::has('error'))
    <!-- Modal Notifications -->
    <div id="modal_notification" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Error!</h4>
                </div>
                <div class="modal-body">
                    <div>{{ Session::get('error') }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $('#modal_notification').modal('show');
    </script>
@endif
<!-- END MODAL NOTIFICATIONS -->

</body>
<!-- MODAL NOTIFICATIONS -->
@include ('admin.partials._modalNotification')
<!-- END MODAL NOTIFICATIONS -->
</html>