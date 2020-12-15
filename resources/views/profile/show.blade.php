@extends('header')
@section('crm')
    <div class="container-fluid ">
<p>hy:{{$user->name}}</p>
@foreach($members as $member)
<p>{{$member->name}}</p>
@if($member->pivot->active ==0)
<form class=""  method="post">
  <a href="/project/{{$member->id}}/member" class="btn btn-primary">Become Member</a>
</form>
@endif
@endforeach
    </div>



@endsection
