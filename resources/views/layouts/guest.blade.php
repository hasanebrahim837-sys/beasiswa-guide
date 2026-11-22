<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IndoScholar') }}</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
        <link rel="icon" type="image/png" href="{{ asset('images/indoscholar-profile.png') }}">
        <meta name="theme-color" content="#4B1A24">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/indoscholar.css') }}">
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background: var(--beige) var(--lattice);">
            <div class="guest-lang">@include('partials.language-switcher')</div>
            <div>
                <a href="/">
                    @include('partials.wordmark', ['class' => 'wordmark-lg'])
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg" style="background: var(--paper); border: 1px solid var(--line); border-radius: 20px;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
