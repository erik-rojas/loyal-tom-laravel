@extends('admin.main')

@section('title', 'New Reminder')

@section('content')

    <div class="page-content">
        <h1 class="page-title"> Create Reminder - Select Ideas</h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="{{route('reminders.index')}}">All Reminders</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>New Reminder</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="page-bar">
            <div class="col-md-10">
                @if(isset($tags))
                    {!! Form::open(['route' => ['reminders.filter', $occasion->id], 'method'=>'post']) !!}
                    <div class="form-inline">
                        <label>Filter by Tags:</label>
                        <select name="tags[]" class="form-control select2" multiple>
                            @foreach($tags as $tag)
                                @if($selected_tags)
                                    <option value="{{$tag->id}}" {{in_array($tag->id, $selected_tags)?'selected':''}}>{{$tag->name}}</option>
                                @else
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                @endif

                            @endforeach
                        </select>
                        <label> Order Ideas by:</label>
                        <select name="status" class="form-control">
                            <option disabled selected>Choose Order</option>
                            <option value="I LIKE THIS IDEA" {{$status == 'I LIKE THIS IDEA'?'selected':''}}>Like</option>
                            <option value="Don't show me this idea any more" {{$status == 'Don\'t show me this idea any more'?'selected':''}}>Dislike</option>
                            <option value="Don’t show this idea for this client" {{$status == 'Don’t show this idea for this client'?'selected':''}}>Don't show for client</option>
                            <option value="I purchased this idea" {{$status == 'I purchased this idea'?'selected':''}}>Bought </option>
                        </select>
                        <button type="submit" class="btn submit">
                            Filter
                        </button>
                    </div>
                    {!! Form::close() !!}
                @endif
            </div>
            <div class="col-md-2">
                <!-- BEGIN HEADER SEARCH BOX -->
                {!! Form::open(['route' => ['reminders.search', $occasion->id], 'method'=>'post']) !!}
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." name="q" value="{{isset($search)?$search:''}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn submit">
                            <i class="icon-magnifier"></i>
                        </button>
                    </span>
                </div>
                {!! Form::close() !!}
                <!-- END HEADER SEARCH BOX -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-9 col-xs-12">

                @if(isset($ideas))

                @foreach($ideas as $idea)

                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="portlet light portlet-fit ">

                            <div class="portlet-body {{(isset($reminder->ideas) && $reminder->ideas()->find($idea->id))?'idea-selected':''}} ">
                                <div class="mt-element-overlay">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mt-overlay-6">
                                                <img src="/upload/ideas/images/{{$idea->image}}" />
                                                <div class="mt-overlay">
                                                    <h2>{!! mb_substr(strip_tags($idea->headline), 0, 30) !!}{{ strlen(strip_tags($idea->headline)) > 30 ? "..." : "" }}</h2>
                                                    <div>
                                                        <span style="color: #fff;"><i class="fa fa-thumbs-o-up"></i> {{$idea->feedbacks->where('status', 'I LIKE THIS IDEA')->count()}}</span>
                                                        <span style="color: #fff;"><i class="fa fa-thumbs-o-down"></i> {{$idea->feedbacks->where('status', 'I don’t like this idea')->count()}}</span>
                                                        <span style="color: #fff;">&#8764;{{$idea->feedbacks->where('status', 'Don’t show this idea for this client')->count()}}</span>
                                                        <span style="color: #fff;"><i class="fa fa-money"></i> {{$idea->feedbacks->where('status', 'I purchased this idea')->count()}}</span>
                                                    </div>
                                                    <p>
                                                        <a class="btn btn-primary" href="{{route('reminders.idea.show', [$occasion->id, $idea->id])}}">
                                                            <span class="fa fa-eye"></span>
                                                        </a>

                                                        @if(isset($reminder->ideas) && $reminder->ideas()->find($idea->id))
                                                            <button class="remove-reminder btn btn-success" data-idea-id="{{$idea->id}}">
                                                                <span class="fa fa-remove"></span>
                                                            </button>
                                                        @else
                                                            <button class="add-reminder btn btn-success" data-idea-id="{{$idea->id}}">
                                                                <span class="fa fa-plus"></span>
                                                            </button>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {!! $ideas->links() !!}

                @else
                    <div class="alert alert-warning" role="alert">No Results Found!</div>
                @endif
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="portlet green-sharp box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Occasion Info
                        </div>
                    </div>
                    <div class="portlet-body">
                        @if(!$occasion->relative)
                            <h5></span> <strong>Reminder Status:</strong></h5>
                            <div>
                                @if($occasion->reminders->count())
                                    <td><span>{{$occasion->lastReminder->status}}</span></td>
                                @else
                                    <td><span class="status-pending">Pending</span></td>
                                @endif
                            </div>
                            <hr />

                            <h5></span> <strong>Reminder due date:</strong></h5>
                            <div>{{$occasion->due_date}}</div>
                            <hr />

                            <h5></span> <strong>User:</strong></h5>
                            <div>{{$occasion->client->clientAdvisor->name}} {{$occasion->client->clientAdvisor->surname}}</div>
                            <hr />

                            <h5></span> <strong>Occasion type:</strong></h5>
                            <div>{{$occasion->type}}</div>
                            <hr />

                            <h5></span> <strong>Occasion Budget:</strong></h5>
                            <div>{{$occasion->budget}}</div>
                            <hr />

                            <h5></span> <strong>Occasion date:</strong></h5>
                            <div>week {{$occasion->date}}</div>
                            <hr />

                            <h5></span> <strong>Client Name:</strong></h5>
                            <div>{{$occasion->client->name}}</div>
                            <hr />

                            <h5></span> <strong>Client Location:</strong></h5>
                            <div>{{$occasion->client->country}}</div>
                            <hr />

                            <h5></span> <strong>Gender:</strong></h5>
                            <div>{{$occasion->client->gender}}</div>
                            <hr />

                            <h5></span> <strong>Age:</strong></h5>
                            <div>{{$occasion->client->age}}</div>
                            <hr />

                            <h5></span> <strong>Enjoys:</strong></h5>
                            <div>
                                <?php $enjoys = explode(",", $occasion->client->like);?>
                                @foreach($enjoys as $enjoy)
                                    <span class="label label-default">{{$enjoy}}</span>
                                @endforeach
                            </div>
                            <hr />

                            <h5></span> <strong>Doesn't enjoy:</strong></h5>
                            <div>
                                <?php $enjoys = explode(",", $occasion->client->dislike);?>
                                @foreach($enjoys as $enjoy)
                                    <span class="label label-default">{{$enjoy}}</span>
                                @endforeach
                            </div>
                            <hr />

                        @else

                            <h5></span> <strong>Reminder Status:</strong></h5>
                            <div>
                                @if($occasion->reminders->count())
                                    <td><span>{{$occasion->lastReminder->status}}</span></td>
                                @else
                                    <td><span class="status-pending">Pending</span></td>
                                @endif
                            </div>
                            <hr />

                            <h5></span> <strong>Reminder URL:</strong></h5>
                            <div><a href="#" target="_blank">URL</a></div>
                            <hr />

                            <h5></span> <strong>Reminder due date:</strong></h5>
                            <div>{{$occasion->due_date}}</div>
                            <hr />

                            <h5></span> <strong>User:</strong></h5>
                            <div>{{$occasion->client->clientAdvisor->user->name}}</div>
                            <hr />

                            <h5></span> <strong>Occasion type:</strong></h5>
                            <div>{{$occasion->type}}</div>
                            <hr />

                            <h5></span> <strong>Occasion Budget:</strong></h5>
                            <div>{{$occasion->budget}}</div>
                            <hr />

                            <h5></span> <strong>Occasion date:</strong></h5>
                            <div>week {{$occasion->date}}</div>
                            <hr />

                            <h5></span> <strong>Client Name:</strong></h5>
                            <div>{{$occasion->client->name}}</div>
                            <hr />

                            <h5></span> <strong>Client Location:</strong></h5>
                            <div>{{$occasion->client->country}}</div>
                            <hr />

                            <h5></span> <strong>Gender:</strong></h5>
                            <div>{{$occasion->gender}}</div>
                            <hr />

                            <h5></span> <strong>Age:</strong></h5>
                            <div>{{$occasion->age}}</div>
                            <hr />

                            <h5></span> <strong>Enjoys:</strong></h5>
                            <div>
                                <?php $enjoys = explode(",", $occasion->like);?>
                                @foreach($enjoys as $enjoy)
                                    <span class="label label-default">{{$enjoy}}</span>
                                @endforeach
                            </div>
                            <hr />

                            <h5></span> <strong>Doesn't enjoy:</strong></h5>
                            <div>
                                <?php $enjoys = explode(",", $occasion->dislike);?>
                                @foreach($enjoys as $enjoy)
                                    <span class="label label-default">{{$enjoy}}</span>
                                @endforeach
                            </div>
                            <hr />
                        @endif

                        {!! Form::open(['route' => ['reminders.delete', $reminder->id], 'method'=>'delete']) !!}
                            <button type="submit" class="btn btn-danger btn-block">Delete Reminder</button>
                        {!! Form::close() !!}

                        <a href="{{route('reminders.preview', $reminder->id)}}" id="submit-reminder" class="btn btn-success btn-block">Preview Reminder</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Notifications -->
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

    <div id="modal_success_deleted" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Success!</h4>
                </div>
                <div class="modal-body">
                    <div>Idea was deleted successfully from the Reminder!</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="modal_warning" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Warning!</h4>
                </div>
                <div class="modal-body">
                    <div>You already have 3 ideas to this reminder!</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="modal_error" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Error!</h4>
                </div>
                <div class="modal-body">
                    <div>You need to add 3 ideas to this reminder!</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('javascript')

    <script src="{{ asset('js/select2.full.js')}}"></script>
    <script type="text/javascript">
        //Select2
        $('.select2').select2();

        //Add idea to reminder
        $(document).on('click', '.add-reminder', function(){

            //Check number of added ideas
            if(Number($('#reminder-ideas-count').text()) < 3){
                var reminder_ides_count = Number($('#reminder-ideas-count').text()) + 1;
                $('.reminder-ideas-count').text(reminder_ides_count);
                $(this).parents('.portlet-body').addClass('idea-selected');
                $(this).addClass('remove-reminder').removeClass('add-reminder').html('<span class="fa fa-remove"></span>');

                var idea_id = $(this).attr('data-idea-id');
                var occasion_id = {{$occasion->id}};
                var token = "{{ csrf_token() }}";
                var url = "{{route('reminders.add-idea')}}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {idea_id:idea_id, occasion_id:occasion_id, _token:token},
                    success: function(data) {
                        console.log(data);
                        $('.ideas-draft').append('' +
                            '<li class="header-idea-'+data.id+'">' +
                            '<a href="/admin/reminders/{{$occasion->id}}/'+data.id+'">' +
                            '<span class="">' +
                            '<img src="/upload/ideas/images/'+data.image+'" alt="" style="width:40px;float:left;">' +
                            '</span>' +
                            '<span class="subject">' +
                            '<span class="from">'+data.headline+'</span>' +
                            '</span>' +
                            '<span class="message">' +data.description.replace(/<\/?[^>]+(>|$)/g, "").substring(0,60)+'...'+
                            '</span>' +
                            '</a>' +
                            '</li>');
                        //Modal with success adding of Idea to Reminder
                        //$('#modal_success').modal('show');
                    }
                });
            }
            else{
                $('#modal_warning').modal('show');
            }
        });

        //Remove Idea From Reminder
        $(document).on('click', '.remove-reminder', function(){
            var reminder_ides_count = Number($('#reminder-ideas-count').text()) - 1;
            $('.reminder-ideas-count').text(reminder_ides_count);
            $(this).parents('.portlet-body').removeClass('idea-selected');
            $(this).removeClass('remove-reminder').addClass('add-reminder').html('<span class="fa fa-plus"></span>');
            var idea_id = $(this).attr('data-idea-id');
            $('.header-idea-'+idea_id).remove();
            var reminder_id = {{$reminder->id}};
            var token = "{{ csrf_token() }}";
            var url = "{{route('reminders.remove-idea')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {idea_id:idea_id, reminder_id:reminder_id, _token:token},
                success: function(data) {
                    console.log(data);
                    $('#modal_success_deleted').modal('show');

                }
            });
        });

        //Submit Reminder
        $('#submit-reminder').on('click', function (e) {
            var reminder_ideas_count = Number($('#reminder-ideas-count').text());
            console.log(reminder_ideas_count);
            if(reminder_ideas_count < 3){
                e.preventDefault();
                $('#modal_error').modal('show');
            }
        });

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

    </script>

@endsection

@section('stylesheets')

    {!! Html::style('css/select2.min.css') !!}

    <style>
        hr{
            margin:10px 0;
        }
        .label{
            display:inline-block;
            margin-top:4px;
        }
        .select2{
            min-width: 50%;
            max-width: 75%;
        }
        .idea-selected{
            background: #17C4BB;
        }
        .portlet.light.portlet-fit>.portlet-body{
            padding:10px;
        }
        .mt-element-overlay .mt-overlay-6 .mt-overlay{
            padding:0px 10px;
        }
        .mt-element-overlay .mt-overlay-6 .mt-overlay h2{
            margin-top:0px;
        }
        .mt-overlay-6{
            text-shadow:1px 1px 1px #000;
        }

    </style>
@endsection