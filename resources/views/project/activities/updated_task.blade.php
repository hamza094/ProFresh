<span class="activity-icon activity-icon_primary"> <i class="fas fa-tasks"></i></span>
@if(count((array)$activity->changes['after']) >= 1)
@foreach ($activity->changes['after'] as $key => $value)
@if($key == 'body')
Updated {{$key}} of the task "{{$activity->subject->body}}"
@elseif($key == 'completed' &  $value == 1)
Task "{{$activity->subject->body}}" marked as <span class="text-success"><b><i>complete</i></b></span>
@elseif($key == 'completed' &  $value == 0)
Task "{{$activity->subject->body}}" marked as <span class="text-danger"><b><i>uncomplete</i></b></span>
@endif
@endforeach
@endif
