@extends('header')
@section('crm')
    <div class="container">
<profile :user="{{json_encode($user)}}"></profile>    	
<p>hy:{{$user->name}}</p>
@if(auth()->user()->id == $user->id)
@foreach($members as $member)
<p>{{$member->name}}</p>
@if($member->pivot->active ==0)
<form class=""  method="post">
  <a href="/project/{{$member->id}}/member" class="btn btn-primary">Become Member</a>
</form>
<br>
<form class=""  method="GET">
  <a href="/project/{{$member->id}}/cancel" class="btn btn-danger">Ignore Invitation</a>
</form>
@endif
@endforeach
@endif
    </div>



@endsection
