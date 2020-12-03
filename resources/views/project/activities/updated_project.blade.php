<span class="activity-icon activity-icon_blue"><i class="far fa-star"></i></span>
@if(count((array)$activity->changes['after']) >= 1)
 @foreach ($activity->changes['after'] as $key => $value)

@if($key == 'stage' &  $value == 0)
Became <b>Unqualifed</b> project

@elseif($key == 'stage' &  $value == 1)
Became <b>New</b> project

@elseif($key == 'stage' & $value == 2)
Became  <b>Contacted</b> project

@elseif($key == 'stage' & $value == 3)
Became <b>Intrested</b> project

@elseif($key == 'stage' & $value == 4)
Became <b>Reviewed</b> project

@elseif($key == 'stage' & $value == 5)
Became <b>Exhibited</b> project

@elseif($key == 'avatar_path' & $value!==null)
Project profile image updated
@elseif($key == 'avatar_path' & $value==null)
Project Profile image removed
@elseif($key == 'account_id')
Account Added to Project
@else
Updated project {{$key}} to <b>{{$value}}</b>
 @endif

 @endforeach
@endif
