<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />

        <!-- Mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="theme-color" content="#ffffff" />

        <!-- SEO -->
        <title inertia>{{ config('app.name', 'ComitsBD') }}</title>

        <meta name="title" content="{{ config('app.name') }}">
        <meta name="description" content="Your website description here">
        <meta name="keywords" content="laravel, vue, inertia, web app">
        <meta name="author" content="Your Company Name">
        <meta name="robots" content="index, follow">
        <meta name="language" content="English">
        <meta name="revisit-after" content="7 days">

        <!-- Canonical -->
        <link rel="canonical" href="{{ url()->current() }}" />

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ config('app.name') }}">
        <meta property="og:description" content="Your website description here">
        <meta property="og:image" content="{{ asset('storage/images/seo/preview.webp') }}">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:locale" content="en_US">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="{{ config('app.name') }}">
        <meta name="twitter:description" content="Your website description here">
        <meta name="twitter:image" content="{{ asset('storage/images/seo/preview.webp') }}">

        <!-- Favicons -->
        @php
            $site = \App\Models\SiteSetting::first();
        @endphp

        @if ($site && $site->favaicon)
            <link rel="icon" type="image/webp" href="{{ asset('storage/' . $site->favaicon) }}">
        @else
            <link rel="icon" type="image/webp" href="{{ asset('/storage/images/logo/logo.webp') }}">
        @endif

        <!-- Apple -->
        <link rel="apple-touch-icon" href="{{ asset('/storage/images/logo/logo.webp') }}">

        <!-- DNS Prefetch -->
        <link rel="dns-prefetch" href="//fonts.googleapis.com">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">

        <!-- Preconnect -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <!-- App -->
        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @inertiaHead

    </head>

    <body>
        @inertia
    </body>

</html>
