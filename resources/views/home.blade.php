@extends('layouts.app')

@section('title', 'Criticly – Főoldal')

@section('content')
<section class="hero reveal">
    <div class="hero_box">
        <span class="hero_badge">Film- és sorozatkritika</span>
        <h1>Találd meg a következő kedvenc filmedet vagy sorozatodat.</h1>
        <p>Modern, gyors és vizuálisan erős felület filmekhez, sorozatokhoz és értékelésekhez.</p>
        <div class="hero_actions">
            <a href="{{ route('movies.index') }}" class="btn btn--primary">Filmek böngészése</a>
            <a href="{{ route('series.index') }}" class="btn btn--ghost">Sorozatok böngészése</a>
        </div>
    </div>

    <div class="hero_side">
        <div class="stat">
            <span>Top kategóriák</span>
            <strong>Akció, dráma, sci-fi</strong>
        </div>
        <div class="stat">
            <span>Friss tartalom</span>
            <strong>Napi frissülő ajánlók</strong>
        </div>
        <div class="stat">
            <span>Közösségi értékelés</span>
            <strong>Review + rating rendszer</strong>
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
            @include('components.movie_card', ['movie' => $movie])
        @endforeach
    </div>
</section>

<section class="section reveal">
    <div class="section_head">
        <h2>Trending most</h2>
    </div>

    <div class="rail" data-rail>
        @foreach($trending as $movie)
            @include('components.movie_card', ['movie' => $movie])
        @endforeach
    </div>
</section>
@endsection