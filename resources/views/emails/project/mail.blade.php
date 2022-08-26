@component('mail::panel')
<b>Subject: </b> <p> {{$subject}}</p>
@endcomponent

@component('mail::message')

<p>{{$message}}</p>

@component('mail::button', ['url' => $url, 'color'=>'primary'])
From Project {{$title}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
