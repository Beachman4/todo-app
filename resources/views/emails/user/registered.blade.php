@component('mail::message')
# Welcome {{ $name }}!

Thanks for registering!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
