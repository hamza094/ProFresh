         <ul>
            @foreach($lead->activity->take(5) as $activity)
             <li>
             @include("lead.activities.{$activity->description}")
                 <p class="activity-info"><span>{{$activity->user->name}} </span><span class="activity-info_dot"></span><span> {{$activity->created_at->diffForHumans(null,true)}} ago</span></p>
             </li>
             @endforeach
             @if($lead->activity->count() > 5)
             <li><span class="activity-more"> <a target="_blank" href="/leads/{{$lead->id}}/timeline_feeds">View More</a> </span></li>
             @endif
         </ul>
