@extends('client.main')

@section('title', 'Client Dashboard')

@section('content')


    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title">
                            <div class="caption">
                               
                                <span class="caption-subject font-dark sbold uppercase"> {{$client->name}}
                                        </span>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet blue-hoki box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                Client Details </div>
                                            <div class="actions">
                                                <a href="javascript:;"  data-toggle="modal" data-target="#editClientData" class="btn btn-default btn-sm">
                                                    <i class="fa fa-pencil"></i> Edit </a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row static-info">
                                                <div class="col-md-4">
                                                    @if ($client->gender == 'Female')
                                                        <img src="/img/avatar_female.png" width="180" height="150">
                                                    @else
                                                        <img src="/img/avatar_male.png" width="180" height="150">
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="value"> {{$client->name}} </div>
                                                    <div class="value"> {{($client->country)}} </div>
                                                    <div class="value"> {{$client->gender}} </div>
                                                    <div class="value"> {{$client->age}} </div>
                                                    <div class="value"> Occasions: {{ $client->occasions->count() }} </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="value"> Address: {{$client->address}} </div>
                                                    <div class="value"> Date of birth: {{ \Carbon\Carbon::parse($client->date_of_birth)->format('d.m.Y') }} </div>
                                                    @foreach($client->occasions as $related)
                                                        @if ($related->relative == 1)
                                                            @php
                                                                $getRetalion = substr($related->type, 0, strpos($related->type, "’s"));
                                                                echo '<div class="value">'.$getRetalion.'</div>';
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End: life time stats -->
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="portlet blue-hoki box">
                        <div class="portlet-title">
                            <div class="caption">
                                {{$client->name}}'s Occasions </div>

                        </div>
                        <div class="portlet-body">
                            @foreach($client->occasions as $occasion)
                                <div class="row static-info">
                                    <div class="col-md-4 value"> {{$occasion->type}}</div>
                                    <div class="col-md-4 value">Week {{$occasion->date}} </div>
                                    <div class="col-md-4 value">
                                        <script>
                                            function ConfirmDelete()
                                            {
                                                var x = confirm("Are you sure you want to delete this occasion?");
                                                if (x)
                                                    return true;
                                                else
                                                    return false;
                                            }
                                        </script>
                                        {{ Form::open(['route' => ['ca.occasion.delete',$occasion->id], 'method' => 'DELETE', 'onsubmit' => 'return ConfirmDelete()']) }}
                                        <button  type="submit" style="background: none;border: none;"><i class="fa fa-trash"></i> </button>
                                        {{ Form::close() }}

                                    </div>
                                </div>
                            @endforeach

                            @if ($occasionAll >= Auth::user()->clientAdvisor->occasion_limit)
                                <div class="custom-alerts alert alert-success fade in">You reached maximum occasions</div>
                            @else
                                <button class="btn blue btn-block btn-outline " id="addOcassion">Add New Occasion</button>
                            @endif
                            <div id="occasion" style="display: none;">
                                {!! Form::open(['route' => 'ca.newOccasion', 'method'=>'post', 'class'=>'form-horizontal form-bordered form-label-stripped']) !!}
                                <div class="form-body">
                                    <h3 class="form_title">Enter the occasion for you client</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">In what calendar week is it?</label>
                                        <div class="col-md-9">
                                        <!--<input type="number" name="dataWeek" id="calendar" min="{{Carbon\Carbon::now()->addWeeks(3)->weekOfYear}}">-->
                                            <input type="number" name="dataWeek" id="calendar" min="1" readonly>
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
                                                    <label class="form-label  capitalize label-like" id="label-like-{{$loop->iteration}}" data-id="{{$loop->iteration}}">
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
                                                    @if($item || $item != 'null')
                                                        <label class="form-label  capitalize label-dislike" id="label-dislike-{{$loop->iteration}}" data-id="{{$loop->iteration}}">
                                                            <input class="hidden"  name="hatesRelative[]" value="{{$item}}" type="checkbox"/>
                                                            <span class='checkbox_item'>{{$item}}</span>
                                                        </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions"><div class="row"><div class="col-md-offset-3 col-md-9"><input type="submit" class="btn btn-primary float-right" value="Submit"></div></div></div>
                                </div>
                                <input type="hidden" value="{{$client_id}}" name="id">
                                <input type="hidden" id="relative" name="relative" value="0">
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="portlet blue-hoki box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-thumbs-o-up"></i>{{$client->name}}'s Likes</div>
                            <div class="caption edit" style="float: right;">
                                <a href="javascript:;" style="color: white;"><i class="fa fa-pencil"></i></a>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <div class="row static-info">
                                <div class="col-md-12">
                                    <?php $likes = explode(",", $client->like);?>
                                    @foreach($likes as $like)
                                        <span class="tagItem like">{{$like}}</span>
                                    @endforeach
                                    <br><br>
                                    {!! Form::open(['route' => ['ca.clientAdvisorLikes.update', $client->id], 'class'=>'formEditable' ,'method'=>'put']) !!}
                                    <div>
                                        @foreach($characters as $character)
                                            <span class="editable tags">
                                                             <input value="{{$character->name}}" id="{{$character->name}}clientDislikes" name="like[]" type="checkbox" class="hidden"
                                                                    @foreach($likes as  $like)
                                                                    @if($like == $character->name )
                                                                    checked
                                                                    @endif
                                                                    @endforeach
                                                                    @if( in_array($character->name, explode(",", $client->dislike)))
                                                                    disabled="disabled"
                                                                     @endif
                                                             />
                                                        <label class="tagItem {{in_array($character->name, explode(",", $client->dislike))?'dislike':''}}" for="{{$character->name}}clientDislikes">{{$character->name}}</label>
                                                        </span>
                                        @endforeach
                                    </div>
                                    <br>
                                    <button type="submit" class="btn green">Update</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet blue-hoki box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-thumbs-o-down"></i>{{$client->name}}'s Dislikes
                            </div>
                            <div class="caption edit" style="float: right;">
                                <a href="javascript:;" style="color: white;"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                        <div class="portlet-body dislike_container">
                            <div class="row static-info">
                                <div class="col-md-12">
                                    <?php $dislikes = explode(",", $client->dislike);?>
                                    @if($client->dislike)
                                        @foreach($dislikes as $dislike)
                                            @if(!($dislike === 'null'))
                                                <span class="tagItem dislike">{{$dislike}}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                    <br><br>
                                    {!! Form::open(['route' => ['ca.clientAdvisorDislikes.update', $client->id], 'class'=>'formEditable' ,'method'=>'put']) !!}
                                    <div>
                                        @foreach($characters as $character)
                                            <span class="editable tags">
                                                             <input value="{{$character->name}}" id="{{$character->name}}clientDislikes{{Auth::user()->id}}" name="dislike[]" type="checkbox" class="hidden"
                                                                    @foreach($dislikes as  $dislike)
                                                                    @if($dislike == $character->name )
                                                                    checked
                                                                    @endif
                                                                    @endforeach
                                                                    @if( in_array($character->name, explode(",", $client->like)))
                                                                    disabled="disabled"
                                                                     @endif
                                                             />
                                                        <label class="tagItem {{in_array($character->name, explode(",", $client->like))?'like':''}}" for="{{$character->name}}clientDislikes{{Auth::user()->id}}">{{$character->name}}</label>
                                                        </span>
                                        @endforeach
                                    </div>
                                    <br>
                                    <button type="submit" class="btn green">Update</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            @foreach($client->occasions as $related)
                @if ($related->relative == 1)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="portlet blue-hoki box">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-thumbs-o-up"></i>
                                        {{$client->name}}'s
                                        @php
                                            $getRetalion = substr($related->type, 0, strpos($related->type, "'s"));
                                            echo $getRetalion;
                                        @endphp's Likes
                                    </div>
                                    <div class="caption edit" style="float: right;">
                                        <a href="javascript:;" style="color: white;"><i class="fa fa-pencil"></i></a>
                                    </div>

                                </div>
                                <div class="portlet-body">
                                    <div class="row static-info">
                                        <div class="col-md-12">
                                            <?php $likes = explode(",", $related->like);?>
                                            @foreach($likes as  $like)
                                                <span class="tagItem like">{{$like}}</span>
                                            @endforeach
                                            <br><br>
                                            {!! Form::open(['route' => ['ca.clientsLikes.update', $related->id], 'class'=>'formEditable' ,'method'=>'put']) !!}
                                            <div>
                                                @foreach($characters as $character)
                                                    <span class="editable tags">
                                                             <input value="{{$character->name}}" id="{{$character->name}}{{$related->id}}" name="like[]" type="checkbox" class="hidden"
                                                                    @foreach($likes as  $like)
                                                                    @if($like == $character->name )
                                                                    checked
                                                                    @endif
                                                                    @endforeach
                                                                    @if( in_array($character->name, explode(",", $related->dislike)))
                                                                    disabled="disabled"
                                                                     @endif
                                                             />
                                                        <label class="tagItem {{in_array($character->name, explode(",", $related->dislike))?'dislike':''}}" for="{{$character->name}}{{$related->id}}">{{$character->name}}</label>
                                                        </span>
                                                @endforeach
                                            </div>
                                            <br>
                                            <button type="submit" class="btn green">Update</button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="portlet blue-hoki box">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-thumbs-o-down"></i>
                                        {{$client->name}}'s
                                        @php
                                            $getRetalion = substr($related->type, 0, strpos($related->type, "’s"));
                                            echo $getRetalion;
                                        @endphp's Dislikes
                                    </div>
                                    <div class="caption edit" style="float: right;">
                                        <a href="javascript:;" style="color: white;"><i class="fa fa-pencil"></i></a>
                                    </div>
                                </div>
                                <div class="portlet-body dislike_container">
                                    <div class="row static-info">
                                        <div class="col-md-12">
                                            <?php $dislikes = explode(",", $related->dislike);?>
                                            @if($related->dislike)
                                                @foreach($dislikes as $dislike)
                                                    @if(!($dislike === 'null'))
                                                        <span class="tagItem dislike">{{$dislike}}</span>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <br><br>
                                            {!! Form::open(['route' => ['ca.clientsDislikes.update', $related->id], 'class'=>'formEditable' ,'method'=>'put']) !!}
                                            <div>
                                                @foreach($characters as $character)
                                                    <span class="editable tags">
                                                             <input value="{{$character->name}}" id="{{$character->name}}{{$related->id}}dislike" name="dislike[]" type="checkbox" class="hidden"
                                                                    @foreach($dislikes as  $dislike)
                                                                    @if($dislike == $character->name )
                                                                    checked
                                                                    @endif
                                                                    @endforeach
                                                                    @if( in_array($character->name, explode(",", $related->like)))
                                                                    disabled="disabled"
                                                                     @endif
                                                             />
                                                        <label class="tagItem {{in_array($character->name, explode(",", $related->like))?'like':''}}" for="{{$character->name}}{{$related->id}}dislike">{{$character->name}}</label>
                                                        </span>
                                                @endforeach
                                            </div>
                                            <br>
                                            <button type="submit" class="btn green">Update</button>
                                            {!! Form::close() !!}

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div id="editClientData" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit client data</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => ['ca.client.update', $client->id], 'method'=>'put']) !!}
                    <div class="row">
                        <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label">Location</label>
                            <select class="form-control form-control-solid placeholder-no-fix form-group" name="location">
                                @foreach($locations as $location)
                                    <option value="{{$location->name}}" @if ($location->name == $client->country) selected @endif>{{$location->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label">Gender</label>
                            {{ Form::select('gender', [
                               'Female' => 'Female',
                               'Male' => 'Male'],
                               $client->gender,
                               ['class' => 'form-control form-control-solid placeholder-no-fix form-group']
                            )}}

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label">Age</label>
                            {{ Form::select('age', [
                               '18-25' => '18-25',
                               '26-36' => '26-36',
                               '36-45' => '36-45',
                               '46-55' => '46-55',
                               '56-65' => '56-65',
                               '65+' => '65+'],
                               $client->age,
                               ['class' => 'form-control form-control-solid placeholder-no-fix form-group']
                            )}}
                        </div>
                    </div>
                    <button class="btn green" type="submit">Submit</button>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
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
                    New occasion has been succesfully created. You have more occasions
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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

@endsection

@section('javascript')
    <script>
        window.id = {{ Request::route('id') }};
    </script>

@endsection

@section('stylesheets')
    <style>
        .tagItem {
            border-radius: 50px;
            margin: 6px;
            display: inline-block;
            text-align: center;
            float: left;
            padding: 2px 4px;
            margin: 2px;
            color: white;
            -webkit-transition: ease 0.3s;
            -moz-transition: ease 0.3s;
            -ms-transition: ease 0.3s;
            -o-transition: ease 0.3s;
            transition: ease 0.3s;
            cursor: pointer;
        }
        .tagItem:hover {
            background:rgb(154, 61, 55);
        }
        .tagItem.like {
            background: #669966;
        }
        .formEditable {
            display: none;
        }
        .tagItem.dislike
        {
            background:rgb(154, 61, 55);
        }
        .editable.tags {
            display: inline-block;
        }
        .editable.tags label{
            background: #999999;
        }
        .editable.tags label.like{
            background: #669966;
        }
        .editable.tags label.dislike{
            background:rgb(154, 61, 55);
        }
        input[type="checkbox"]:checked + label {
            background: #669966;
        }
        .dislike_container input[type="checkbox"]:checked + label {
            background:rgb(154, 61, 55);
        }
        .label-dislike input:checked + span {
            background: rgb(154, 61, 55);
        }
        label.checkbox_item.gender{

            cursor: pointer;
        }

    </style>

    <style>
        input:checked + span {
            background: #669966;
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