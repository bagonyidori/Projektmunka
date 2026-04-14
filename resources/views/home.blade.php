@extends('layouts.app')

@section('title', 'Criticly - Főoldal')

@section('content')
    <section class="hero reveal">
        <div class="hero_box">
            <span class="hero_badge">Film- és sorozatkritika</span>
            <h1>Találd meg a következő kedvenc filmedet vagy sorozatodat.</h1>
            <p>Modern, gyors és vizuálisan erős felület filmekhez, sorozatokhoz és értékelésekhez.</p>
            <div class="hero_actions">
                <a href="{{ route('movies.index') }}" class="btn btn--primary">Filmek böngészése</a>
            </div>
        </div>

        <div class="hero_side">
            <div class="stat">
                <span>Top kategóriák</span>
                <strong>Akció, Dráma, Sci-Fi</strong>
            </div>
            <div class="stat">
                <span>Napi ajánlók</span>
                <strong>Friss, válogatott tartalom</strong>
            </div>
            <div class="stat">
                <span>Közösségi értékelések</span>
                <strong>Valódi vélemények</strong>
            </div>
        </div>
    </section>

    <section class="section reveal">
        <div class="section_head">
            <h2>Kiemelt filmek</h2>
            <a href="{{ route('movies.index') }}">Összes film</a>
        </div>

        <div class="grid">
            @foreach($featured as $movie)
                @include('components.movie-card', ['movie' => $movie])
            @endforeach
        </div>
    </section>

    <section class="section reveal">
        <div class="section_head">
            <h2>Legjobbra értékelt</h2>
            <div class="swiper_nav">
                <div class="swiper-button-prev trending-prev"></div>
                <div class="swiper-button-next trending-next"></div>
            </div>
        </div>

        <div class="swiper trending-swiper">
            <div class="swiper-wrapper">
                @foreach($trendingMovies as $trendy)
                    <div class="swiper-slide">
                        @include('components.movie-card', ['movie' => $trendy->movie])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section reveal">
        <div class="section_head">
            <h2>Napi válogatás</h2>
            <div class="swiper_nav">
                <div class="swiper-button-prev daily-prev"></div>
                <div class="swiper-button-next daily-next"></div>
            </div>
        </div>

        <div class="swiper daily-swiper">
            <div class="swiper-wrapper">
                @foreach($dailyMovies as $daily)
                    <div class="swiper-slide">
                        @include('components.movie-card', ['movie' => $daily->movie])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section reveal">
        <div class="section_head">
            <h2>Közelgő filmek</h2>
            <div class="swiper_nav">
                <div class="swiper-button-prev daily-prev"></div>
                <div class="swiper-button-next daily-next"></div>
            </div>
        </div>

        <div class="swiper daily-swiper">
            <div class="swiper-wrapper">
                @foreach($upcomingMovies as $movie)
                    <div class="swiper-slide">
                        @include('components.movie-card', ['movie' => $movie])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
@endsection