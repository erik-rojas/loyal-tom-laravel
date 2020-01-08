@extends('client.main')

@section('title', 'Client Dashboard')

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered form-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-user font-blue-hoki"></i>
                                <span class="caption-subject font-blue-hoki bold uppercase">Add new client</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            @if($occasionAll >= Auth::user()->clientAdvisor->occasion_limit)
                                <div class="custom-alerts alert alert-success fade in">Sorry, you reached maximum number of occasions</div>
                            @endif
                            {!! Form::open(['route' => 'ca.clients.store', 'method'=>'post', 'class'=>'form-horizontal form-bordered form-label-stripped', 'id' => 'form-client']) !!}

                            <div class="form-body">
                                <h3 class="form_title" style="margin-left:20px;">Choose the preference for your client</h3>

                                <div class="form-group checkbox">
                                    <label class="control-label col-md-3">Name</label>
                                    <div class="col-md-9" >
                                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                            <input class="form-control placeholder-no-fix" type="text"  name="name" value="{{ old('name') }}" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group checkbox">
                                    <label class="control-label col-md-3">Address, Postal Code, City</label>
                                    <div class="col-md-9" >
                                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                            <input class="form-control placeholder-no-fix" type="text"  name="address" value="{{ old('address') }}" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group checkbox">
                                    <label class="control-label col-md-3">Date of birth</label>
                                    <div class="col-md-9" >
                                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                            <input type="date" name="date_of_birth" class="" value="{{ old('date_of_birth') }}" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group checkbox">
                                    <label class="control-label col-md-3">Female or Male?</label>
                                    <div class="col-md-9" >
                                        <label class="form-label capitalize checkbox_item gender" ><input class="form-checkbox hidden"  type="radio" name="gender" value="Male" />Male</label>
                                        <label class="form-label capitalize checkbox_item gender" ><input  class="form-checkbox hidden "  type="radio" name="gender" value="Female" />Female</label>
                                    </div>
                                </div>

                                <div class="form-group  ageRange">
                                    <label class="control-label col-md-3">What is her or his age?</label>
                                    <div class="col-md-9" >
                                        @foreach($ageOptions as $item)
                                            <label class="form-label capitalize">
                                                <input type="radio" class="form-checkbox hidden" name="ageRange" value="{{$item}}">
                                                <span class="checkbox_item">{{$item}}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">What does she or he enjoy?</label>
                                    <div class="col-md-9" >
                                        @foreach($character as $item)
                                            <label class="form-label capitalize label-like" id="label-like-{{$loop->iteration}}" data-id="{{$loop->iteration}}">
                                                <input class="hidden"  name="enjoys[]" value="{{$item}}" type="checkbox"/>
                                                <span class='checkbox_item'>{{$item}}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">What doesn’t she or he enjoy?</label>
                                    <div class="col-md-9" >
                                        @foreach($character as $item)
                                            <label class="form-label capitalize label-dislike" id="label-dislike-{{$loop->iteration}}" data-id="{{$loop->iteration}}">
                                                <input class="hidden"  name="hates[]" value="{{$item}}" type="checkbox"/>
                                                <span class='checkbox_item'>{{$item}}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <h3 class="form_title" style="margin-left:20px;">Enter the occasion for you client</h3>
                                <div class="form-group">
                                    <label class="control-label col-md-3">When is the occasion?</label>
                                    <div class="col-md-9">
                                        <input type="text" class="calendar-date" name="occasion_date" required readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3"> What is the occasion?</label>
                                    <div class="col-md-9">
                                        <select class="form-control select2" name="type" id="relativeSelect" required="required">
                                            <option value="Birthday">Birthday</option>
                                            <option value="Business anniversary">Business anniversary</option>
                                            <option value="Buying a car">Buying a car</option>
                                            <option value="Buying a house">Buying a house</option>
                                            <option value="Buying a motorcycle">Buying a motorcycle</option>
                                            <option value="Buying a yacht">Buying a yacht</option>
                                            <option value="Casual surprise/Just because!">Casual surprise/Just because!</option>
                                            <option value="Christening of a child">Christening of a child</option>
                                            <option value="Christmas">Christmas</option>
                                            <option value="Close of a deal">Close of a deal</option>
                                            <option value="Condolences">Condolences</option>
                                            <option value="Daughter's birthday">Daughter's birthday</option>
                                            <option value="Friend's birthday">Friend's birthday</option>
                                            <option value="Getting a pet">Getting a pet</option>
                                            <option value="Having a baby">Having a baby</option>
                                            <option value="Holidays">Holidays</option>
                                            <option value="Investing in real estate">Investing in real estate</option>
                                            <option value="Loved one's birthday">Loved one's birthday</option>
                                            <option value="New year's">New year's</option>
                                            <option value="Promotion">Promotion</option>
                                            <option value="Son's birthday">Son's birthday</option>
                                            <option value="Wedding anniversary">Wedding anniversary</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Budget for this occasion</label>
                                    <div class="col-md-9">
                                        <select name="budget" class="form-control">
                                            <option value="200">Max CHF 200 - for an excellent surprise</option>
                                            <option value="100">Max CHF 100 - for a quality surprise</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="additional">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Male/Female </label>
                                        <div class="col-md-9">
                                            <label class="form-label capitalize checkbox_item gender"><input type="radio" class="form-checkbox hidden" id="input-male" name="genderRelative" value="Male">Male</label>
                                            <label class="form-label capitalize checkbox_item gender"><input type="radio" class="form-checkbox hidden" id="input-female" name="genderRelative" value="Female">Female</label>
                                        </div>
                                    </div>
                                    <div class="form-group checkbox ageRange">
                                        <label class="control-label col-md-3">What is her or his age?</label>
                                        <div class="col-md-9" >
                                        <span class="option">
                                            @foreach($ageOptions as $item)
                                                <label class="form-label capitalize checkbox_item">
                                                <input type="radio" class="form-checkbox hidden" name="ageRangeRelative" value="{{$item}}">
                                                    <span>{{$item}}</span></label>
                                            @endforeach
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">What does she or he enjoy?</label>
                                        <div class="col-md-9" >
                                            @foreach($character as $item)
                                                <label class="form-label capitalize label-like" id="label-like-{{$loop->iteration}}1" data-id="{{$loop->iteration}}1">
                                                    <input class="hidden"  name="enjoysRelative[]" value="{{$item}}" type="checkbox"/>
                                                    <span class='checkbox_item'>{{$item}}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">What doesn’t she or he enjoy?</label>
                                        <div class="col-md-9" >
                                            @foreach($character as $item)
                                                <label class="form-label capitalize label-dislike" id="label-dislike-{{$loop->iteration}}1" data-id="{{$loop->iteration}}1">
                                                    <input class="hidden"  name="hatesRelative[]" value="{{$item}}" type="checkbox"/>
                                                    <span class='checkbox_item'>{{$item}}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>



                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input
                                                    type="submit"
                                                    class="btn btn-primary float-right"
                                                    value="Submit"/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" id="relative" name="relative" value="0">
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT BODY -->
        </div>


        <!-- Modal Notifications -->
        <div id="modal_enjoys" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Warning!</h4>
                    </div>
                    <div class="modal-body">
                        <div>Client's Enjoys is required!</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="modal_account" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Public or private?</h4>
                    </div>
                    <div class="modal-body">
                        <div>By clicking this option, you are choosing to save some information on our server. We want to confirm you that we are not going to disclose any of your data to any third parties and you can edit and delete it from our server any time. Thanks for trusting us!</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Public</button>
                        <a href="{{ route('ca.add.private') }}" class="btn btn-default">Go to private</a>
                    </div>
                </div>

            </div>
        </div>


        <style>
            input:checked + span {
                background: #669966;
            }
            .label-dislike input:checked + span {
                background: rgb(154, 61, 55);
            }
            .hidden {
                display: none;
            }
            .checkbox_item {
                border: 1px solid transparent;
                border-radius: 50px;
                padding: 2px 4px;
                margin: 2px;
                color: white;
                text-indent: -13px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background: #999999;
                min-height: 20px;
                padding-left: 20px;
                margin-bottom: 0;
                font-weight: 400;
                cursor: pointer;
                display: inline-block;
            }
            .additional {
                display: none;
            }

        </style>



        @endsection

        @section('javascript')
            <script type="text/javascript">
                $('#form-client').submit(function (e){
                    if($('input[name="enjoys[]"]:checked').length == 0){
                        e.preventDefault();
                        $('#modal_enjoys').modal('show');
                    }
                });

                //$('#modal_account').modal('show');

                $('.calendar-date').datepicker({
                    showWeek: true,
                    minDate:"+3w",
                });
            </script>
@endsection