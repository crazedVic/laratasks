@component('mail::message')

{{$message_text}}

@component('mail::button', ['url' => '{{$url}}', 'color' => 'primary'])
Click Button
@endcomponent
<a href="{{$url}}" class="button button-primary">Action</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
