<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LoyalTom</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="{{ asset('css/media.css')}}" rel="stylesheet" type="text/css" />

        <!-- Styles -->
        <style>
            html, body {
                background-color: silver;
                color: #fff;
                font-family: 'Montserrat', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .img-logo {
                color: #fff;
                width: 115px;
                position: relative;
                left: -5px;
            }

            .h3-text {
                font-size: 25px;
                font-family: Montserrat !important;
                position: relative;
            }

            .title {
                font-size: 54px;
                color: #fff;
            }

            .links > a {
                color: #fff;
                padding: 0 25px;
                font-size: 20px;
                font-family: Montserrat !important;
                font-weight: 600;
                text-decoration: underline;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
                color: #fff;
            }
            footer {
                position:fixed;
                bottom: 5px;
                color:#484c50;
                text-align: center;
                color: #fff;
                text-align: center;
                position: fixed;
                overflow: hidden;
                bottom: 0;
                width: 100%;
                height: auto;
                background: rgb(0, 0, 0) !important;
                background: rgba(0, 0, 0, 0.5) !important;
                color: white !important;
                font-family: 'OpenSans', sans-serif !important;
                font-weight: 400 !important;
                font-size: 12px;
                padding-top: 5px;
            }
            footer a {
                font-weight: 600!important;;
                color: white !important;
                text-decoration: none;
            }
        </style>
    </head>
    <body style="background-image: url('../img/background_image_demoloyaltom.png'); background-position: center center; background-size: cover;  ">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                   <img class="img-logo" src="/img/02-LoyalTom_white.svg" style="">
                </div>
                <h4 class="h3-text"> The better client retention solution.</h4>
                @if (Route::has('login'))
                    <div class="links">
                        @if (Auth::check())
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ url('/login') }}">Login</a>
                            <a href="{{ url('/register') }}">Register</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
