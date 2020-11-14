<span class="activity-icon activity-icon_blue"><i class="far fa-star"></i></span>
@if(count((array)$activity->changes['after']) >= 1)
 @foreach ($activity->changes['after'] as $key => $value)

@if($key == 'stage' &  $value == 0)
Became <b>Unqualifed</b> lead

@elseif($key == 'stage' &  $value == 1)
Became <b>New</b> lead

@elseif($key == 'stage' & $value == 2)
Became  <b>Contacted</b> lead

@elseif($key == 'stage' & $value == 3)
Became <b>Intrested</b> lead

@elseif($key == 'stage' & $value == 4)
Became <b>Reviewed</b> lead

@elseif($key == 'stage' & $value == 5)
Became <b>Exhibited</b> lead

@elseif($key == 'avatar_path' & $value!==null)
Lead profile image updated
@elseif($key == 'avatar_path' & $value==null)
Lead Profile image removed
@else
Updated lead {{$key}} to <b>{{$value}}</b>
 @endif

 @endforeach
@endif
