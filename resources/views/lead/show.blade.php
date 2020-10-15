@extends('header')
@section('crm')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-8 page pd-r">
                <div class="page-top">
                    <div>
            <span>
                <span class="page-top_heading">Leads </span>
                <span class="page-top_arrow"> > </span>
                <span> {{$lead->name}}</span>
            </span>
                        <div class="float-right">
                            buttons
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <div class="row">
                        <div class="col-md-2">
                      <single-lead :lead="{{$lead}}"></single-lead>
                        </div>
                        <div class="col-md-10">
                            <div class="content">
                                <p class="content-name">{{$lead->name}}</p>
                                <p class="content-info">Sales Manager<span class="content-dot"></span>Widjets.co</p>
                                <p class="content-map"><i class="fas fa-map-marker-alt"></i><a href="http://maps.google.com/?q=1200 Pennsylvania Ave SE, Washington, District of Columbia, 20003" target="_blank">Mongolia, Usa</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                by
            </div>
        </div>
    </div>



@endsection


