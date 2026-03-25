@extends('layouts.app')

@section('content')
<div class="movie_detail_wrapper reveal">
    <a href="{{ route('home') }}" class="btn back_btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Vissza a filmekhez
    </a>

    <div class="movie_detail_grid">
        <div class="movie_detail_poster">
            @if($movie->poster)
                <img src="{{ 'https://image.tmdb.org/t/p/original' . $movie->poster }}" alt="{{ $movie->title }}">
            @else
                <div class="poster_placeholder">Nincs kép</div>
            @endif
        </div>
        
        <div class="movie_detail_info">
            <h1>{{ $movie->title }}</h1>
            
            <div class="movie_badges">
                <span class="badge">{{ date('Y-m-d', strtotime($movie->releaseDate)) }}</span>
                <span class="badge">{{ $movie->genre }}</span>
            </div>
            
            <div class="movie_plot">
                <h3>Történet</h3>
                <p>{{ $movie->plot }}</p>
            </div>
        </div>
    </div>
</div>

<div class="related_movies_section reveal">
    <h2>Hasonló filmek</h2>
    <div class="grid">
        @foreach($related as $relatedMovie)
            @include('components.movie-card', ['movie' => $relatedMovie])
        @endforeach
    </div>
</div>
@endsection