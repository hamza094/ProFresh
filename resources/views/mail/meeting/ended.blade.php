@component('mail::message')
# Meeting Ended

A meeting has ended for the project: [{{ $projectName }}]({{ $projectLink }})

**Topic:** {{ $meetingTopic }}
**Start Time:** {{ $startTime }}  
**Timezone:** {{ $timezone }}
**Started By:** {{ $userName }}
**Ends At:** {{ $endTime }}  


@component('mail::button', ['url' => $projectLink])
Join Meeting
@endcomponent

Thank you for using our application!

@endcomponent