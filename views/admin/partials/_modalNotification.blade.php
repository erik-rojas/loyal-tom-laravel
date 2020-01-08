@if (Session::has('success'))
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
                    <div>{!! Session::get('success') !!}</div>
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

@elseif (count($errors)>0)
    <!-- Modal Notifications Warning-->
    <div id="modal_notification_warning" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content bg-warning">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Warning!</h4>
                </div>
                <div class="modal-body">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $('#modal_notification_warning').modal('show');
    </script>
@endif

@if (Session::has('error'))
    <!-- Modal Notifications -->
    <div id="modal_notification" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Error!</h4>
                </div>
                <div class="modal-body">
                    <div>{{ Session::get('error') }}</div>
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




