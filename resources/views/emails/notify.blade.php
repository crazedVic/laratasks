@component('mail::message')
# Introduction

{{$message_text}}

@component('mail::button', ['url' => '', 'color' => 'primary'])
Click Button
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
