<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Loyal Tom</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of Metronic Admin Theme #2 for statistics, charts, recent events and reports" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ asset('css/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/jqvmap/jqvmap/jqvmap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" /
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('css/global/css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('css/global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('css/layout2/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/layout2/css/layout.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/layout2/css/themes/blue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ asset('css/global/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/layout2/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/admin-main.css')}}" rel="stylesheet" type="text/css" />

    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="/favicon.ico" />
    @yield('stylesheets')
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>