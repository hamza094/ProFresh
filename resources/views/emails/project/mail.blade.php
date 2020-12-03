
@component('mail::panel')
{{$subject}}
@endcomponent

@component('mail::message')
{{$message}}


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
