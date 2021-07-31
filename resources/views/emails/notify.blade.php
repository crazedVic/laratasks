@component('mail::message')

{{$message_text?: ''}}

{{-- Copied styling from button component, doing it this way to allow for custom urls --}}
<div style="display:flex;justify-content:center;width:full;">
<a href="{{$button_url?: ''}}" class="button button-primary">
    {{$button_text?: 'Action'}}
</a>
</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
