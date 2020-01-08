<!DOCTYPE html>
<html>
<head>
    <head>
        <meta charset="utf-8" />
        <title>Daily Report</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #2 for statistics, charts, recent events and reports" name="description" />
        <meta content="" name="author" />
        <style>

            html {
                font-family: sans-serif;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            hr {
                margin-top: 20px;
                margin-bottom: 20px;
                border: 0;
                border-top: 1px solid #eeeeee;
            }
            .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                margin: -1px;
                padding: 0;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                border: 0;
            }
            .sr-only-focusable:active,
            .sr-only-focusable:focus {
                position: static;
                width: auto;
                height: auto;
                margin: 0;
                overflow: visible;
                clip: auto;
            }
            [role="button"] {
                cursor: pointer;
            }
            table {
                background-color: transparent;
            }
            caption {
                padding-top: 8px;
                padding-bottom: 8px;
                color: #777777;
                text-align: left;
            }
            th {
                text-align: left;
            }
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
            .table > thead > tr > th,
            .table > tbody > tr > th,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > tbody > tr > td,
            .table > tfoot > tr > td {
                padding: 8px;
                line-height: 1.42857143;
                vertical-align: top;
                border-top: 1px solid #dddddd;
            }
            .table > thead > tr > th {
                vertical-align: bottom;
                border-bottom: 2px solid #dddddd;
            }
            .table > caption + thead > tr:first-child > th,
            .table > colgroup + thead > tr:first-child > th,
            .table > thead:first-child > tr:first-child > th,
            .table > caption + thead > tr:first-child > td,
            .table > colgroup + thead > tr:first-child > td,
            .table > thead:first-child > tr:first-child > td {
                border-top: 0;
            }
            .table > tbody + tbody {
                border-top: 2px solid #dddddd;
            }
            .table .table {
                background-color: #ffffff;
            }
            .table-condensed > thead > tr > th,
            .table-condensed > tbody > tr > th,
            .table-condensed > tfoot > tr > th,
            .table-condensed > thead > tr > td,
            .table-condensed > tbody > tr > td,
            .table-condensed > tfoot > tr > td {
                padding: 5px;
            }
            .table-bordered {
                border: 1px solid #dddddd;
            }
            .table-bordered > thead > tr > th,
            .table-bordered > tbody > tr > th,
            .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td,
            .table-bordered > tbody > tr > td,
            .table-bordered > tfoot > tr > td {
                border: 1px solid #dddddd;
            }
            .table-bordered > thead > tr > th,
            .table-bordered > thead > tr > td {
                border-bottom-width: 2px;
            }
            .table-striped > tbody > tr:nth-of-type(odd) {
                background-color: #f9f9f9;
            }
            .table-hover > tbody > tr:hover {
                background-color: #f5f5f5;
            }
            table col[class*="col-"] {
                position: static;
                float: none;
                display: table-column;
            }
            table td[class*="col-"],
            table th[class*="col-"] {
                position: static;
                float: none;
                display: table-cell;
            }
            .table > thead > tr > td.active,
            .table > tbody > tr > td.active,
            .table > tfoot > tr > td.active,
            .table > thead > tr > th.active,
            .table > tbody > tr > th.active,
            .table > tfoot > tr > th.active,
            .table > thead > tr.active > td,
            .table > tbody > tr.active > td,
            .table > tfoot > tr.active > td,
            .table > thead > tr.active > th,
            .table > tbody > tr.active > th,
            .table > tfoot > tr.active > th {
                background-color: #f5f5f5;
            }
            .table-hover > tbody > tr > td.active:hover,
            .table-hover > tbody > tr > th.active:hover,
            .table-hover > tbody > tr.active:hover > td,
            .table-hover > tbody > tr:hover > .active,
            .table-hover > tbody > tr.active:hover > th {
                background-color: #e8e8e8;
            }
            .table > thead > tr > td.success,
            .table > tbody > tr > td.success,
            .table > tfoot > tr > td.success,
            .table > thead > tr > th.success,
            .table > tbody > tr > th.success,
            .table > tfoot > tr > th.success,
            .table > thead > tr.success > td,
            .table > tbody > tr.success > td,
            .table > tfoot > tr.success > td,
            .table > thead > tr.success > th,
            .table > tbody > tr.success > th,
            .table > tfoot > tr.success > th {
                background-color: #dff0d8;
            }
            .table-hover > tbody > tr > td.success:hover,
            .table-hover > tbody > tr > th.success:hover,
            .table-hover > tbody > tr.success:hover > td,
            .table-hover > tbody > tr:hover > .success,
            .table-hover > tbody > tr.success:hover > th {
                background-color: #d0e9c6;
            }
            .table > thead > tr > td.info,
            .table > tbody > tr > td.info,
            .table > tfoot > tr > td.info,
            .table > thead > tr > th.info,
            .table > tbody > tr > th.info,
            .table > tfoot > tr > th.info,
            .table > thead > tr.info > td,
            .table > tbody > tr.info > td,
            .table > tfoot > tr.info > td,
            .table > thead > tr.info > th,
            .table > tbody > tr.info > th,
            .table > tfoot > tr.info > th {
                background-color: #d9edf7;
            }
            .table-hover > tbody > tr > td.info:hover,
            .table-hover > tbody > tr > th.info:hover,
            .table-hover > tbody > tr.info:hover > td,
            .table-hover > tbody > tr:hover > .info,
            .table-hover > tbody > tr.info:hover > th {
                background-color: #c4e3f3;
            }
            .table > thead > tr > td.warning,
            .table > tbody > tr > td.warning,
            .table > tfoot > tr > td.warning,
            .table > thead > tr > th.warning,
            .table > tbody > tr > th.warning,
            .table > tfoot > tr > th.warning,
            .table > thead > tr.warning > td,
            .table > tbody > tr.warning > td,
            .table > tfoot > tr.warning > td,
            .table > thead > tr.warning > th,
            .table > tbody > tr.warning > th,
            .table > tfoot > tr.warning > th {
                background-color: #fcf8e3;
            }
            .table-hover > tbody > tr > td.warning:hover,
            .table-hover > tbody > tr > th.warning:hover,
            .table-hover > tbody > tr.warning:hover > td,
            .table-hover > tbody > tr:hover > .warning,
            .table-hover > tbody > tr.warning:hover > th {
                background-color: #faf2cc;
            }
            .table > thead > tr > td.danger,
            .table > tbody > tr > td.danger,
            .table > tfoot > tr > td.danger,
            .table > thead > tr > th.danger,
            .table > tbody > tr > th.danger,
            .table > tfoot > tr > th.danger,
            .table > thead > tr.danger > td,
            .table > tbody > tr.danger > td,
            .table > tfoot > tr.danger > td,
            .table > thead > tr.danger > th,
            .table > tbody > tr.danger > th,
            .table > tfoot > tr.danger > th {
                background-color: #f2dede;
            }
            .table-hover > tbody > tr > td.danger:hover,
            .table-hover > tbody > tr > th.danger:hover,
            .table-hover > tbody > tr.danger:hover > td,
            .table-hover > tbody > tr:hover > .danger,
            .table-hover > tbody > tr.danger:hover > th {
                background-color: #ebcccc;
            }
            .table-responsive {
                overflow-x: auto;
                min-height: 0.01%;
            }
            @media screen and (max-width: 767px) {
                .table-responsive {
                    width: 100%;
                    margin-bottom: 15px;
                    overflow-y: hidden;
                    -ms-overflow-style: -ms-autohiding-scrollbar;
                    border: 1px solid #dddddd;
                }
                .table-responsive > .table {
                    margin-bottom: 0;
                }
                .table-responsive > .table > thead > tr > th,
                .table-responsive > .table > tbody > tr > th,
                .table-responsive > .table > tfoot > tr > th,
                .table-responsive > .table > thead > tr > td,
                .table-responsive > .table > tbody > tr > td,
                .table-responsive > .table > tfoot > tr > td {
                    white-space: nowrap;
                }
                .table-responsive > .table-bordered {
                    border: 0;
                }
                .table-responsive > .table-bordered > thead > tr > th:first-child,
                .table-responsive > .table-bordered > tbody > tr > th:first-child,
                .table-responsive > .table-bordered > tfoot > tr > th:first-child,
                .table-responsive > .table-bordered > thead > tr > td:first-child,
                .table-responsive > .table-bordered > tbody > tr > td:first-child,
                .table-responsive > .table-bordered > tfoot > tr > td:first-child {
                    border-left: 0;
                }
                .table-responsive > .table-bordered > thead > tr > th:last-child,
                .table-responsive > .table-bordered > tbody > tr > th:last-child,
                .table-responsive > .table-bordered > tfoot > tr > th:last-child,
                .table-responsive > .table-bordered > thead > tr > td:last-child,
                .table-responsive > .table-bordered > tbody > tr > td:last-child,
                .table-responsive > .table-bordered > tfoot > tr > td:last-child {
                    border-right: 0;
                }
                .table-responsive > .table-bordered > tbody > tr:last-child > th,
                .table-responsive > .table-bordered > tfoot > tr:last-child > th,
                .table-responsive > .table-bordered > tbody > tr:last-child > td,
                .table-responsive > .table-bordered > tfoot > tr:last-child > td {
                    border-bottom: 0;
                }
            }
        </style>
    </head>
</head>
<body>
<div class="row">
    <div class="col-md-6">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-globe font-dark hide"></i>
                    <h1>Notifications for LoyalTom on {{date('d.m.Y', strtotime(Carbon\Carbon::yesterday()))}}</h1>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="dataTable">
                    <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Idea</th>
                    <th>Amount of Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    </thead>
                    <tbody>
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
                            <td><a href="{{route('ideas.show', $payment->idea->id)}}" target="_blank">{{$payment->idea->headline}}</a></td>
                            <td>{{$payment->amount/100}} {{$payment->currency}} </td>
                            <td>
                                <div class="form-inline">
                                    <select name="status" class="form-control select-status" data-payment-id="{{$payment->id}}">
                                        <option {{($payment->status == 'New')?'selected':''}} value="New">New</option>
                                        <option {{($payment->status == 'In Process')?'selected':''}} value="In Process">In Process</option>
                                        <option {{($payment->status == 'Closed')?'selected':''}} value="Closed">Closed</option>
                                    </select>
                                    <span id="status-saved-{{$payment->id}}" class="status-saved btn btn-success glyphicon glyphicon-floppy-saved"></span>
                                </div>
                            </td>
                            <td>{{$payment->created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>