@extends('layouts.auth')

@section('content')

    <div class="col-md-6 login-container bs-reset">
        <a href="/"><img class="login-logo login-6" src="{{ asset('img/SurpriseClub_logo.jpeg') }}" /></a>
        <div class="login-content">
            <h1>RESET YOUR PASSWORD</h1>


            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group col-xs-12 ">
                    <label for="email" class="control-label">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif

                </div>

                <div class="form-group col-xs-12 ">

                        <button type="submit" id="register-submit-btn" class="btn uppercase  btn-custom pull-right"> Send Password Reset Link</button>

                </div>

            </form>
        </div>

        @if (session('status'))


            <!-- Modal Notifications -->
            <div id="modal_notification" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Success!</h4>
                        </div>
                        <div class="modal-body">
                            <div>{{ session('status') }}</div>
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

@endsection


