@component('mail::message')
# Here are your todo items for today!

@foreach($todoItems as $item)
    {{ $item->title }}
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
