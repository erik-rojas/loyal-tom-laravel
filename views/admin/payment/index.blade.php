@extends('admin.main')

@section('title', 'All Payments')

@section('content')

    <div class="page-content">
        <h1 class="page-title"> All Payments<small> </small></h1>
        <!-- BREADCRUMBS-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{route('home')}}">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>All Payments</span>
                </li>
            </ul>
        </div>
        <!-- END BREADCRUMBS-->

        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover" id="dataTable">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Client</th>
                        <th>Idea</th>
                        <th>Amount of Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{$payment->id}}</td>
                            <td>{{$payment->user->name}}</td>
                            <td>{{$payment->user->email}}</td>
                            <td>
                                {{$payment->user->clientAdvisor->street}},
                                {{$payment->user->clientAdvisor->city}},
                                {{$payment->user->clientAdvisor->code}},
                                {{$payment->user->clientAdvisor->country}}
                            </td>
                            <td>{{$payment->user->clientAdvisor->mobile_phone}}</td>
                            <td>{{isset($payment->reminder->occasion->client->name)?$payment->reminder->occasion->client->name:''}}</td>
                            <td>
                                @if(isset($payment->idea))
                                    <a href="{{route('ideas.show', $payment->idea->id)}}" target="_blank">{{$payment->idea->headline}}</a>
                                @else
                                    Idea was deleted
                                @endif
                            </td>
                            <td>{{$payment->amount/100}} {{$payment->currency}} </td>
                            <td>
                                <div class="form-inline">
                                    <select name="status" class="form-control select-status {{$payment->status == 'New'?'red':''}}{{$payment->status == 'In Process'?'yellow':''}}{{$payment->status == 'Closed'?'green':''}}" data-payment-id="{{$payment->id}}">
                                        <option {{($payment->status == 'New')?'selected':''}} value="New">New</option>
                                        <option {{($payment->status == 'In Process')?'selected':''}} value="In Process">In Process</option>
                                        <option {{($payment->status == 'Closed')?'selected':''}} value="Closed">Closed</option>
                                    </select>
                                </div>
                            </td>
                            <td>{{$payment->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            table = $('#dataTable').DataTable({
                "pageLength": 50
            });
        });

        //Change Status
        $('.select-status').on('change', function(){
            var status = $(this).val();
            if(status == 'New'){
                $(this).removeClass('yellow green').addClass('red');
            }
            if(status == 'In Process'){
                $(this).removeClass('red green').addClass('yellow');
            }
            if(status == 'Closed'){
                $(this).removeClass('yellow red').addClass('green');
            }
            var payment_id = $(this).attr("data-payment-id");
            var token = "{{ csrf_token() }}";
            var url = "{{route('payments.change-status')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {status:status, payment_id:payment_id, _token:token},
                success: function(data) {
                    console.log('success');
//                    $('#status-saved-'+payment_id).show().css({
//                        "opacity" : "1",
//                        "transition" : "opacity 2s ease-in-out"
//                    });
                }
            });
        });
    </script>

@endsection

@section('stylesheets')
    <style>
        .status-saved{
            opacity: 0;
        }
        .red{
            background: #f00;
            color:#fff;
        }
        .yellow{
            background: #ebdb1f;
            color:#fff;
        }
        .green{
            background: #17C4BB;
            color:#fff;
        }
    </style>

@endsection