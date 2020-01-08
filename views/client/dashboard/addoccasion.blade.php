<?php
/**
 * @todo Move this file to ClientAdvisor/Client/index.blade.php
 */
?>
@extends('client.main')

@section('title', 'Clients')

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->

            <h1 class="page-title"> Your clients
            </h1>
            <!-- BREADCRUMBS-->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{route('home')}}">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span> Your clients</span>
                    </li>
                </ul>
            </div>
            <!-- END BREADCRUMBS-->
            <!-- BEGIN PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-layers font-green"></i>
                                <span class="caption-subject font-green bold uppercase">Choose a client you want to add the occasion for</span>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="mt-element-card mt-card-round mt-element-overlay">
                                <div class="row">
                                    @foreach( $clients as $client)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <a class="" href="{{route('ca.occasionitem', ['id' => $client->id])}}" style="text-decoration: none;">
                                        <div class="mt-card-item">
                                            <div class=" mt-overlay-1">
                                                @if ($client->gender == 'Female')
                                                    <img src="/img/avatar_female.png" />
                                                @else
                                                    <img src="/img/avatar_male.png" />
                                                @endif

                                                <div class="" style="cursor: pointer;">
                                                </div>
                                            </div>
                                            <div class="mt-card-content">
                                                <h3 class="mt-card-name">{{$client->name}}</h3>
                                                <p class="mt-card-desc font-grey-mint">{{ $client->country ? $client->country : $client->address  }}</p>
                                                <p class="mt-card-desc font-grey-mint"> Number of occasions:  {{count($client->occasions)}}</p>

                                            </div>
                                        </div>
                                        </a>
                                    </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- END CONTENT BODY -->
    </div>


@endsection