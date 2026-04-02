<nav class="navbar">
    <a class="nav_brand" href="{{ route('home') }}">
        <img src="{{ asset('img/logo.png') }}" alt="critiqly logo" class="logo-class">
    </a>

    <form class="nav_search" action="{{ route('movies.index') }}" method="GET">
        <input type="search" name="search" placeholder="Keresés..." value="{{ request('search') }}" autocomplete="off">
        @if(request('genre'))
            <input type="hidden" name="genre" value="{{ request('genre') }}">
        @endif
    </form>

    <div class="nav_links">
        <a href="{{ route('home') }}">Főoldal</a>
        <a href="{{ route('movies.index') }}">Filmek</a>
        <a href="{{ route('about') }}">Rólunk</a>
    </div>

    @guest
        <div class="nav_auth">
            <a href="{{ route('login') }}" class="btn btn--ghost">Belépés</a>
            <a href="{{ route('register') }}" class="btn btn--primary">Regisztráció</a>
        </div>
    @endguest

    @auth
        <span>Üdv, {{ Auth::user()->name }}</span>
        <a href="{{ route('profile') }}" class="btn btn--ghost">Profilom</a>
        <form action="{{ route('user.logout') }}" method="POST">
            @csrf
            <button class="btn btn--primary">Logout</button>
        </form>
    @endauth
</nav>