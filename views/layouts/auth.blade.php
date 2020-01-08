<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="{{ asset('css/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('css/global/css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('css/global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.5.3/datepicker.css" rel="stylesheet" type="text/css">

    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ asset('css/pages/login-5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/media.css')}}" rel="stylesheet" type="text/css" />

    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <style>
        html, body{
            font-family: 'Montserrat', sans-serif;
        }
        .btn-custom {
            color: #fff;
            background-color: #203139;
            border-color: #203139;
        }
        .btn-custom:hover, .btn-custom:focus {
            color: #fff;
        }
        .user-login-5 .login-container > .register-content {
            margin-top: 14%;
        }
        .user-login-5 .login-container > .register-content > .login-form .form-control {
            margin-bottom: 10px;
        }
        .user-login-5 .register-logo {
            top: 20px!important;
            left: 80px;
        }
        .user-login-5 .login-container > .login-content > .register-form {
            margin-top: 20px;
        }
        .visible-ie8, .visible-ie9{
            visibility: visible;
            display: block;
        }
    </style>
</head>

<body class="login">

<div class="user-login-5">
    <div class="row bs-reset">

        @yield('content')
            <div class="login-footer">
                <div class="row bs-reset">

                    <div class="col-xs-12 bs-reset">
                        <div class="login-copyright text-left leftAlign" style="padding-left: 80px;">
                            <p style="font-size: 11px; margin-bottom: 30px; float: left;">© 2018  LoyalTom.com | All rights reserved</p>
                            <a href="mailto:welcome@loyaltom.com?subject=LoyalTom - Questions/Feedback" style="float: left; font-size: 11px; margin-left: 40px;">Any questions/Feedback?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 bs-reset hide-media">
            <div class="login-bg"> </div>
        </div>
    </div>
</div>




<!-- END CORE PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('css/global/scripts/app.js')}}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('css/pages/scripts/login-5.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="{{ asset('css/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('css/global/plugins/backstretch/jquery.backstretch.min.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.5.3/datepicker.js"></script>

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->


<!-- MODAL NOTIFICATIONS -->
@include ('admin.partials._modalNotification')
<!-- END MODAL NOTIFICATIONS -->
<script>
    $('#dateBirth').datepicker();

//    $('input[type=text]').on('keypress', function (event) {
//        var regex = new RegExp("^[a-zA-Z0-9]+$");
//        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
//        if (!regex.test(key)) {
//            event.preventDefault();
//            console.log('false');
//            return false;
//        }
//    });
</script>
</body>
</html>
