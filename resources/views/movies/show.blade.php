@extends('layouts.app')

@section('title', $movie->title . ' – Criticly')

@section('content')
<section class="detail_hero reveal">
    <div class="detail_poster">
        <img src="{{ $movie->poster ?? asset('images/placeholder.jpg') }}" alt="{{ $movie->title }}">
    </div>

    <div class="detail_info">
        <span class="hero_badge">{{ $movie->genre ?? 'Film' }}</span>
        <h1>{{ $movie->title }}</h1>
        <div class="detail_metrics">
            <span>Év: {{ $movie->year ?? '—' }}</span>
            <span>★ {{ $movie->rating ?? 'N/A' }}</span>
            <span>{{ $movie->runtime ?? '—' }} perc</span>
        </div>
        <p>{{ $movie->description }}</p>

        <div class="hero_actions">
            <button class="btn btn--primary" id="favBtn" type="button">Kedvenc</button>
            <button class="btn btn--ghost" id="shareBtn" type="button">Megosztás</button>
        </div>
    </div>
</section>

<section class="section reveal">
    <div class="section_head">
        <h2>Hasonló ajánlások</h2>
    </div>

    <div class="grid">
        @foreach($related as $movie)
            @include('components.movie_card', ['movie' => $movie])
        @endforeach
    </div>
</section>
@endsection
