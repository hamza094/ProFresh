@extends('header')
@section('crm')
    <div class="container-fluid">
    <div class="row">
    	<div class="col-md-8 page pd-r">
    <profile :user="{{json_encode($user)}}" :members="{{json_encode($members)}}"></profile>    	
    	</div>
    </div>	
    </div>

@endsection