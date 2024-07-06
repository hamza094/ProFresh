@component('mail::message')
# Meeting Started

A meeting has started for the project: [{{ $projectName }}]({{ $projectLink }})

**Topic:** {{ $meetingTopic }}  
**Start Time:** {{ $startTime }}  
**Timezone:** {{ $timezone }}
**Started By:** {{ $userName }}


@component('mail::button', ['url' => $joinUrl])
Join Meeting
@endcomponent

Thank you for using our application!

@endcomponent