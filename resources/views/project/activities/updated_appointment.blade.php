<span class="activity-icon activity-icon_appoint"> <i class="far fa-calendar-check"></i></span>
@if(count((array)$activity->changes['after']) >= 1)
@foreach ($activity->changes['after'] as $key => $value)
Updated <b>{{$key}}</b> to <i>{{$value}}</i>,
@endforeach
of the appointment "{{$activity->subject->title}}"
@endif
