<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')

            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        <!-- Favicon -->
		<link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <!-- Styles -->

        <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ url(mix('js/app.js')) }}" defer></script>

        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        @yield('body')

        <script>
            // for(i=0; i<document.forms.length; i++){
            //     document.forms[i].style.visibility = 'hidden';
            // }

            document.addEventListener('livewire:load', function () {
                //console.log('livewire load');
                // for(i=0; i<document.forms.length; i++){
                //     document.forms[i].style.visibility = 'visible';
                // }
            });

            document.addEventListener('livewire:available', function () {
                //console.log('livewire available');
                // for(i=0; i<document.forms.length; i++){
                //     document.forms[i].style.visibility = 'visible';
                // }
            });
            document.addEventListener('livewire:update', function (e) {
                //console.log(e);
                // for(i=0; i<document.forms.length; i++){
                //     document.forms[i].style.visibility = 'visible';
                // }
            });
        </script>
        @livewireScripts
    </body>
</html>
