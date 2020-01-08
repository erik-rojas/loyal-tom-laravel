@extends('admin.main')

@section('title', 'Feedbacks')

@section('content')
    <div class="page-content">
        <h1 class="page-title"> Feedbacks</h1>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover" id="reminders-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ClientAdvisor</th>
                        <th>Client Name</th>
                        <th>ClientAdvisor Email</th>
                        <th>Idea</th>
                        <th>Feedback</th>
                        <th>Date Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($feedbacks as $feedback)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{isset($feedback->client->clientAdvisor->name)?$feedback->client->clientAdvisor->name:''}}</td>
                            <td>{{isset($feedback->client->name)?$feedback->client->name:''}}</td>
                            <td>{{isset($feedback->client->clientAdvisor->user->email)?$feedback->client->clientAdvisor->user->email:''}}</td>
                            <td>
                                @if(isset($feedback->idea))
                                    <a href="{{route('ideas.show', $feedback->idea->id)}}">{{$feedback->idea->headline}}</a>
                                @else
                                    <span>Idea was Deleted</span>
                                @endif
                            </td>
                            <td>{{$feedback->status}}</td>
                            <td data-order="{{strtotime($feedback->created_at)}}">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $feedback->created_at)->format('H:i d.m.Y')}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('css/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('css/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            table = $('#reminders-table').DataTable({
                "pageLength": 50,
                "sScroll": false,
            });
        });
    </script>

@endsection

@section('stylesheets')

@endsection