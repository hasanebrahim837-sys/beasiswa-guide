<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>@hasSection('title')@yield('title') | @endif{{ config('app.name', 'IndoScholar') }} — Your guide to scholarships in Indonesia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="IndoScholar helps international students find scholarships in Indonesia and prepare their applications.">
    <meta name="theme-color" content="#4B1A24">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('images/indoscholar-profile.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <meta property="og:site_name" content="IndoScholar">
    <meta property="og:image" content="{{ asset('images/indoscholar-profile.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/indoscholar.css') }}">
</head>

@php
    $waNumber = config('app.whatsapp');
    $waDisplay = config('app.whatsapp_display');
    $waLink = 'https://wa.me/' . $waNumber;
@endphp

<body>
    <nav class="navbar">
        <a href="{{ route('home') }}">@include('partials.wordmark')</a>

        <div class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('scholarships.index') }}">Scholarships</a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a href="{{ route('admin.assistance_requests.index') }}">Requests</a>
                    <a href="{{ route('admin.scholarships.index') }}">Manage Scholarships</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth

            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-cta">
                @include('partials.whatsapp-icon') Contact us
            </a>
        </div>
    </nav>

    <main>
        @hasSection('content')
            @yield('content')
        @else
            @isset($slot)
                {{ $slot }}
            @endisset
        @endif
    </main>

    <footer class="footer">
        <div class="footer-top">
            @include('partials.wordmark')

            <div class="footer-contact">
                <span class="footer-phone">{{ $waDisplay }}</span>
                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-cta">
                    @include('partials.whatsapp-icon') Contact us on WhatsApp
                </a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} IndoScholar. We help you apply — scholarships are offered and decided by their official providers.</span>
            <span>Always apply through the official links.</span>
        </div>
    </footer>
</body>

</html>
