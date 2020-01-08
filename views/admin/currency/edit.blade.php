@extends('admin.main')

@section('title', 'Settings')

@section('content')

    <div class="page-content">
        <h1 class="page-title">Settings</h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Settings</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->


        <div class="row">
            <div class="col-md-6">

                {!! Form::open(['route' => 'exchange-rate.update', 'method'=>'put']) !!}
                    <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> Exchange Rate</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body form">

                        <div class="form-body">
                            @foreach($currencies as $currency)
                                <div class="form-group">
                                    <label for="{{$currency->name}}">{{$currency->name}}:</label>
                                    <input type="text" name="{{$currency->name}}" value="{{$currency->rate}}" class="form-control" required>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}

            </div>
            <div class="col-md-6">

                {!! Form::open(['route' => 'setting.update', 'method'=>'put']) !!}
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> Occasions limit</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body form">

                        <div class="form-body">
                            <div class="form-group">
                                <label>Occasions used:</label>
                                <input type="text" value="{{$occasions_count}}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="{{$limits->name}}">Occasions total limit:</label>
                                <input type="text" name="setting" value="{{$limits->value}}" class="form-control" required>
                            </div>
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

                {!! Form::open(['route' => 'expiration.update', 'method'=>'put']) !!}
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> CONTRACT EXPIRATION DATE</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body form">

                        <div class="form-body">
                            <div class="form-group">
                                <label for="{{$expiration->name}}">{{$expiration->name}}:</label>
                                <input type="text" name="setting" value="{{$expiration->value}}" class="form-control" required>
                            </div>
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}

            </div>
            <div class="col-md-6">


            </div>
        </div>

    </div>

    <div id="modal_success" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <div>Idea was added successfully to the Reminder!</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('javascript')

@endsection

@section('stylesheets')

@endsection