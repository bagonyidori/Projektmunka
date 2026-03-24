<nav class="navbar">
    <a class="nav_brand" href="{{ route('home') }}">
        <span class="nav_logo">C</span>
        <span>Criticly</span>
    </a>

    <form class="nav_search" action="{{ route('movies.index') }}" method="GET">
        <input type="search" name="q" placeholder="Keresés filmekre, sorozatokra..." autocomplete="off">
        <button type="submit">Keresés</button>
    </form>

    <div class="nav_links">
        <a href="{{ route('home') }}">Főoldal</a>
        <a href="{{ route('movies.index') }}">Filmek</a>       
    </div>
</nav>