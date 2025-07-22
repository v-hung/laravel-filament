<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', settings('shop.site_name'))</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        @filamentStyles
        @vite(['resources/css/app.css'])
        @stack('styles')
    </head>
    <body>
        @include('partials.header')

        <div class="container">
            @yield('content')
        </div>

        @include('partials.footer')

        @livewire('notifications')

        @filamentScripts
        @vite(['resources/js/app.js'])
        @stack('scripts')
    </body>
</html>
