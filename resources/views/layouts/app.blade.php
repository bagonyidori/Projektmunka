<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b0f19">
    <title>@yield('title', 'Criticly')</title>
    
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('components.navbar')

    <div class="page_shell">
        @yield('content')
    </div>

    <button class="theme_toggle" id="themeToggle" type="button" aria-label="Téma váltása">
        <span class="theme_toggle_icon">◐</span>
    </button>

    <div class="notification" id="notification"></div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>