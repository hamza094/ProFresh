@extends('header')
@section('crm')

    <div class="container-fluid">
    <div class="row">
    	<div class="col-md-8 page pd-r">
    <profile :user="{{json_encode($user)}}" :members="{{json_encode($members)}}"></profile>    	
    	</div>
    	<div class="col-md-4">
    		<h3>Subscriptions</h3>
            <h5><span><b>Monthly:$15</b></span>
                <span class="float-right"><b>Yearly:$150</b></span>
            </h5>
            <hr>
            @if ($user->subscribed('main')) 

     @include('profile.stripeSubscription')
    
     @elseif($paypal == 'subscribed')
 
    <h5>You are Currently Subscribed with paypal</h5>

    @else
 
    @include('profile.paypalSubscription')

     @endif
</div>
    </div>	
    </div>

@endsection

@include('profile.paypalScript')
  
