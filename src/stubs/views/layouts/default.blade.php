<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="" />
        <meta name="keywords" content="" />

        <title>{{ config('app.name') }}</title>
        @include('layouts.partials.favicon')

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="environment" content="{{ config('app.env') }}" />
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body class="font-sans antialiased text-black leading-tight">

        <div id="app">
            @yield('body')
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
        @stack('javascript')
    </body>
</html>