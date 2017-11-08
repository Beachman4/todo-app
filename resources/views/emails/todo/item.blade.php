@component('mail::message')
# Here are your todo items for today!

@foreach($todoItems as $item)
    @if($item->url)
        @component('mail::button', ['url' => $item->url, 'color' => 'green'])
            {{ $item->title }}
        @endcomponent
    @else
        {{ $item->title }}
    @endif
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
