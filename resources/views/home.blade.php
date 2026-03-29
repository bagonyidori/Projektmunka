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
        <h2>Felkapott most</h2>
    </div>

    <div class="rail" data-rail>
        @foreach($trending as $movie)
            @include('components.movie-card', ['movie' => $movie])
        @endforeach
    </div>
</section>
<section class="section reveal">
    <div class="section_head">
        <h2>Napi válogatás</h2>
    </div>

    <div class="rail" data-rail>
        @foreach($dailyMovies as $daily)
            @include('components.movie-card', ['movie' => $daily->movie])
        @endforeach
    </div>
</section>
@endsection