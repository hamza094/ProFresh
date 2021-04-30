<span class="activity-icon activity-icon_appoint"> <i class="far fa-calendar-check"></i></span>
   Removed <a href='/api/profile/user{{strrchr($activity->detail, '/_/')}}' target="_blank">
     {{strtok($activity->detail, '/_/')}}
   </a> from appointment "{{$activity->subject->title}}"
