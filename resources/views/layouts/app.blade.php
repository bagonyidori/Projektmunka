<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b0f19">
    <title>@yield('title', 'Criticly')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="preloader">
    <div class="loader-box">
        <img src="/img/Page_Loader.gif" alt="Loading..." class="loader-gif">
    </div>
</div>
    @include('components.navbar')

    <div class="page_shell">
        @yield('content')
    </div>

    <button class="theme_toggle" id="themeToggle" type="button" aria-label="Téma váltása">
        <span class="theme_toggle_icon">◐</span>
    </button>

    <div class="notification" id="notification"></div>

</body>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
</html>