<nav class="navbar">
    <a class="nav_brand" href="{{ route('home') }}">
        <span class="nav_logo">C</span>
        <span>Criticly</span>
    </a>

    <form class="nav_search" action="{{ route('movies.index') }}" method="GET">
        <input type="search" name="q" placeholder="Keresés..." autocomplete="off">
    </form>

    <div class="nav_links">
        <a href="{{ route('home') }}">Főoldal</a>
        <a href="{{ route('movies.index') }}">Filmek</a>       
        <a href="{{ route('about') }}">Rólunk</a> </div>

    <div class="nav_auth">
        <a href="{{ route('login') }}" class="btn btn--ghost">Belépés</a>
        <a href="{{ route('register') }}" class="btn btn--primary">Regisztráció</a>
    </div>
</nav>