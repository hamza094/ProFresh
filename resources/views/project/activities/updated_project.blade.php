<span class="activity-icon activity-icon_blue"><i class="far fa-star"></i></span>
@if(count((array)$activity->changes['after']) >= 1)
@foreach ($activity->changes['after'] as $key => $value)

@if($key == 'stage' &  $value == 0)
Became <b>Postponed</b> project

@elseif($key == 'stage' &  $value == 1)
Project phase converted to <b>Initial</b>

@elseif($key == 'stage' & $value == 2)
Project phase converted to <b>Defined</b>

@elseif($key == 'stage' & $value == 3)
Project phase converted to <b>Designing</b>

@elseif($key == 'stage' & $value == 4)
Project phase converted to <b>Developing</b>

@elseif($key == 'stage' & $value == 5)
Project phase converted to <b>Execution</b>

@elseif($key == 'stage' & $value == 6)
Project phase converted to <b>Closure</b>

@elseif($key == 'account_id')
Account Added to Project

@elseif($key == 'group_id')
Group Chat Added to the project

@else
Updated project <i>{{$key}}</i> to <b>{{ Str::limit($value, 25) }} </b>

@endif
@endforeach
@endif
