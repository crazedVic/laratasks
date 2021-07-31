@component('mail::message')

{{$message_text}}

{{-- Copied styling from button component, doing it this way to allow for custom urls --}}
<div style="display:flex;justify-content:center;width:full;">
<a href="{{$url}}" class="button button-primary">
    Action
</a>
</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
