@extends('admin.main')

@section('title', 'Edit Idea')

@section('content')

    <div class="page-content">
        <h1 class="page-title">{{$idea->headline}} - Edit<small> </small></h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Create New Idea</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        {!! Form::open(['route' => ['ideas.update', $idea->id], 'method'=>'PUT', 'files' => 'true', 'id'=>'fileupload']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Main Info
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body">

                            <div class="form-group {{ $errors->has('headline') ? ' has-error' : '' }}">
                                <label for="headline">Idea title*:</label>
                                <input type="text" class="form-control" name="headline" value="{{ $idea->headline }}" required>
                                @if ($errors->has('headline'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('headline') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address">Shop address*:</label>
                                <textarea class="form-control" name="address" required>{{ $idea->address }}</textarea>
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label>Description*:</label>
                                <textarea class="text-editor" name="description">{{ $idea->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                @foreach($idea->dates as $date)
                                    <div id="data-group-{{$loop->iteration}}" class="data-group">
                                        <label for="daterange[{{$loop->iteration}}]">Date [{{$loop->iteration}}]:</label>
                                        <button class="btn btn-delete-date btn-danger btn-sm" data-date-id="{{$loop->iteration}}" style="float:right;"><span class="glyphicon glyphicon-remove"></span></button>
                                        <input type="text" name="daterange[{{$loop->iteration}}]" value="{{ date('Y-m-d', strtotime($date->date))  }}" class="daterange form-control" />
                                    </div>
                                @endforeach
                                <div id="new-dates"></div>
                                <button id="add-new-field" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add dates</button>
                            </div>

                            <br />
                            <label for="price">Price*:</label>
                            <div class="form-inline {{ $errors->has('price') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" name="price" value="{{ $idea->price }}" placeholder="150.00" pattern="\d+(\.\d{2})?" required>
                                <select name="currency_id" class="form-control">
                                    @foreach($currencies as $currency)
                                        @if($currency->id == $idea->currency_id)
                                            <option value="{{$currency->id}}" selected>{{$currency->name}}</option>
                                        @else
                                            <option value="{{$currency->id}}">{{$currency->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <label for="additional_price">Additional Price <small><small>(CHF)</small></small>*: </label>
                            <div class="form-inline {{ $errors->has('additional_price') ? ' has-error' : '' }}">
                                <input type="number" class="form-control" name="additional_price" value="{{ $idea->additional_price }}" placeholder="50.00" pattern="\d+(\.\d{2})?" min="1" required>
                                @if ($errors->has('additional_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('additional_price') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
                                <label for="url">Shop URL*:</label>
                                <input type="text" class="form-control" name="url" value="{{ $idea->url }}" required>
                                @if ($errors->has('url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('button_buy_text') ? ' has-error' : '' }}">
                                <label for="button_buy_text">Button buy text*:</label>
                                <input type="text" class="form-control" name="button_buy_text" value="{{ $idea->button_buy_text }}" required>
                                @if ($errors->has('button_buy_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('button_buy_text') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('button_buy_for_me_text') ? ' has-error' : '' }}">
                                <label for="button_buy_for_me_text">Button buy for me text*:</label>
                                <input type="text" class="form-control" name="button_buy_for_me_text" value="{{ $idea->button_buy_for_me_text }}" required>
                                @if ($errors->has('button_buy_for_me_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('button_buy_for_me_text') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="tags">Tags:</label>
                                <select name="tags[]" class="form-control select2" multiple>
                                    @foreach($tags as $tag)
                                        <?php $show = true;?>
                                        @foreach($idea->tags as $idea_tag)
                                            @if($tag->name == $idea_tag->name)
                                                <option selected value="{{$tag->id}}">{{$tag->name}}</option>
                                                <?php $show = false;?>
                                            @endif
                                        @endforeach

                                        @if($show)
                                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="portlet box purple">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Images & Video
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body">

                            <div class="form-group">
                                <h5>Main Image:</h5>
                                <img src="/upload/ideas/images/{{$idea->image}}" style="width:50%;"/>
                            </div>
                            <div class="form-group">
                                <span class="btn green fileinput-button">
                                    <i class="fa fa-plus"></i>
                                    <span> Change Main Image </span>
                                    <input type="file" name="main_image" accept="image/jpeg,image/png,image/gif" />
                                </span>
                            </div>

                            <div class="form-group">
                                <h5>Additional Images:</h5>
                                @foreach($idea->ideaImages as $image)
                                    <div class="img-container" id="img-container-{{$image->id}}">
                                        <img src="/upload/ideas/images/{{$image->name}}"/>
                                        <button class="btn btn-delete-image btn-danger btn-sm " data-image-id="{{$image->id}}"><span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group fileupload-buttonbar">
                                <span class="btn green fileinput-button">
                                    <i class="fa fa-plus"></i>
                                    <span> Additional Images </span>
                                    <input type="file" name="additional_images[]" multiple="" accept="image/jpeg,image/png,image/gif" />
                                </span>
                            </div>

                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped clearfix">
                                <tbody class="files"> </tbody>
                            </table>

                            <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
                            <script id="template-upload" type="text/x-tmpl">
                            {% for (var i=0, file; file=o.files[i]; i++) { %}
                                <tr class="template-upload fade">
                                    <td>
                                        <span class="preview"></span>
                                    </td>
                                    <td>
                                        <p class="name">{%=file.name%}</p>
                                        <strong class="error label label-danger"></strong>
                                    </td>
                                    <td>
                                        <p class="size">Processing...</p>
                                    </td>

                                </tr> {% }
                            %}
                            </script>

                            <!-- The template to display files available for download -->
                            <script id="template-download" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
                                <tr class="template-download fade">
                                    <td>
                                        <span class="preview"> {% if (file.thumbnailUrl) { %}
                                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
                                                <img src="{%=file.thumbnailUrl%}">
                                            </a> {% } %} </span>
                                    </td>
                                    <td>
                                        <p class="name"> {% if (file.url) { %}
                                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl? 'data-gallery': ''%}>{%=file.name%}</a> {% } else { %}
                                            <span>{%=file.name%}</span> {% } %} </p> {% if (file.error) { %}
                                        <div>
                                            <span class="label label-danger">Error</span> {%=file.error%}</div> {% } %} </td>
                                    <td>
                                        <span class="size">{%=o.formatFileSize(file.size)%}</span>
                                    </td>
                                </tr> {% } %}
                            </script>

                            <div class="form-group {{ $errors->has('video') ? ' has-error' : '' }}">
                                <label for="video">Video URL (YouTube):</label>
                                <input type="text" class="form-control" name="video" value="{{ $idea->video }}" placeholder="https://www.youtube.com/embed/dsJtgmAhFF4">
                                @if ($errors->has('video'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('video') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block">Submit</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
@endsection

@section('javascript')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{ asset('js/select2.full.js')}}"></script>

    <script src="{{ asset('css/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/vendor/load-image.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/jquery.fileupload.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js')}}" type="text/javascript"></script>

    <script>
        var FormFileUpload = function () {
            return {
                //main function to initiate the module
                init: function () {
                    // Initialize the jQuery File Upload widget:
                    $('#fileupload').fileupload({});
                }
            };
        }();

        jQuery(document).ready(function() {
            FormFileUpload.init();
        });
    </script>

    <script type="text/javascript">

        //Select2
        $('.select2').select2();

        //Tinymce Editor
        tinymce.init({
            selector:'.text-editor',
            plugins:'link code'
        });

        //DateRangePicker
        $('.daterange').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            singleDatePicker: true,
            showDropdowns: true
        });

        //DateRangePicker
        $('.daterange').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            singleDatePicker: true,
            showDropdowns: true
        });

        //Add Dates
        var i = {{$idea->dates->count() + 1}};
        $('#add-new-field').on('click', function(e){
            e.preventDefault();
            $('#new-dates').append('' +
                '<div id="data-group-'+i+'" class="data-group">' +
                '<label for="daterange['+i+']">Date ['+i+']:</label>' +
                '<button class="btn btn-delete-date btn-danger btn-sm" data-date-id="'+i+'" style="float:right;"><span class="glyphicon glyphicon-remove"></span></button>' +
                '<input type="text" name="daterange['+i+']" class="daterange form-control" /></div>');
            i++;
            //DateRangePicker
            $('.daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                singleDatePicker: true,
                showDropdowns: true
            });

        });

        //Delete Date Field
        $(document).on('click', '.btn-delete-date', function(e){
            e.preventDefault();
            id = $(this).attr('data-date-id');
            $('#data-group-'+id).remove();
        });

        //Delete Images
        $('.btn-delete-image').on('click', function (e){
            e.preventDefault();
            image_id = $(this).attr('data-image-id');
            var token = "{{ csrf_token() }}";
            var url = "{{route('ideas.image-delete')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {id:image_id, _token:token},
                success: function(data) {
                    console.log(data);
                    $('#img-container-'+image_id).remove();
                }
            });
        })

    </script>
@endsection

@section('stylesheets')
    {!! Html::style('css/select2.min.css') !!}
    <link href="{{ asset('css/global/plugins/jquery-file-upload/css/jquery.fileupload.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/global/plugins/jquery-file-upload/css/jquery.fileupload.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .data-group{margin:10px 0;}
        .img-container{width:50%; position:relative; margin:10px 0;}
        .img-container img{display:block; width:100%;}
        .img-container button{position:absolute !important; top:5px; right:5px;}
    </style>
@endsection