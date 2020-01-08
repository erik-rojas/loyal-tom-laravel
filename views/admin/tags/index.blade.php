@extends('admin.main')

@section('title', 'All Tags')

@section('content')

    <div class="page-content">
        <h1 class="page-title"> All Tags<small> </small></h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>All Tags</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="row" style="margin-bottom:15px;">
            <div class="col-md-3 col-md-offset-9">
                <button class="btn btn-block btn-primary add-new-tag"><span class="fa fa-plus"></span> Add new Tag</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover" id="dataTable">
                    <thead>
                    <th>#</th>
                    <th>Tag</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td id="tag-{{$tag->id}}">{{$tag->name}}</td>
                            <td>
                                <button class="btn btn-primary edit-tag" data-tag-id="{{$tag->id}}" data-tag-name="{{$tag->name}}"><span class="fa fa-edit"></span></button>
                                <button class="btn btn-primary delete-tag" data-tag-id="{{$tag->id}}" data-tag-name="{{$tag->name}}"><span class="fa fa-trash"></span></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--EDIT TAG-->
    <div id="modal_edit_tag" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editing Tag</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_tag_name">Tag Name:</label>
                        <input type="text" class="form-control" id="new_tag_name" name="new_tag_name"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit-edit-tag" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!--DELETE TAG-->
    <div id="modal_delete" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Tag</h4>
                </div>
                <div class="modal-body">
                    <h5>Do you want to delete tag - <span id="deleting-tag"></span>?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit-delete-tag" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!--ADD TAG-->
    <div id="modal_add_tag" class="modal fade" role="dialog">
        <div class="modal-dialog">
        {!! Form::open(['route' => 'tags.store', 'method'=>'POST']) !!}
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Tag</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_tag_name">Tag Name:</label>
                        <input type="text" class="form-control" id="new_tag_name" name="new_tag_name"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            table = $('#dataTable').DataTable({
                "pageLength": 200
            });
        });

        //Edit Tag
        $('.edit-tag').on('click', function(){
            tag_id = $(this).attr('data-tag-id');
            tag_name = $(this).attr('data-tag-name');
            $('#new_tag_name').val(tag_name);
            $('#modal_edit_tag').modal('show');
        });

        $('#submit-edit-tag').on('click', function(){
            new_tag_name = $('#new_tag_name').val();
            var token = "{{ csrf_token() }}";
            var url = "{{route('tags.update')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {tag_id:tag_id, new_tag_name:new_tag_name, _token:token},
                success: function(data) {
                    $('#tag-'+tag_id).html(new_tag_name);
                    $('#modal_edit_tag').modal('hide');
                }
            });
        });

        //Delete Tag
        $('.delete-tag').on('click', function(){
            delete_tag_id = $(this).attr('data-tag-id');
            tag_name = $(this).attr('data-tag-name');
            $('#deleting-tag').html(tag_name);
            $('#modal_delete').modal('show');
        });

        $('#submit-delete-tag').on('click', function () {
            var token = "{{ csrf_token() }}";
            var url = "{{route('tags.delete')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {tag_id:delete_tag_id, _token:token},
                success: function(data) {
                    $('#modal_delete').modal('hide');
                    $('#tag-'+delete_tag_id).parent('tr').remove();
                }
            });
        })

        //Add New Tag
        $('.add-new-tag').on('click', function(){
            $('#modal_add_tag').modal('show');
        })

    </script>

@endsection

@section('stylesheets')

@endsection