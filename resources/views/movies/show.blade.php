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
                <span class="badge">{{ date('Y/m/d', strtotime($movie->releaseDate)) }}</span>
                <span class="badge">{{ $movie->genre }}</span>
                <span class="badge badge--rating">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px; height:14px; margin-right:4px;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                    {{ $movie->rating }}
                </span>
            </div>
            
            <div class="movie_plot">
                <h3>Történet</h3>
                <p>{{ $movie->plot }}</p>
            </div>
            <div class="movie_actions">
                <button id="favBtn" class="btn favBtn btn--primary {{ $movie->is_favorite ? 'is_active' : '' }}" data-id="{{ $movie->id }}">
                <svg class="favBtn-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                Kedvencekhez
                </button>
    
                <button id="shareBtn" class="btn btn--ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>
                Megosztás
                </button>
            </div>
        </div>
    </div>
</div>

<section class="movie_reviews reveal">
    <div class="section_header">
        <h2>Vélemények</h2>
        <span class="review_count"> *szám* hozzászólás</span>
    </div>

    @auth
        <form action="" method="POST" class="review_form">
            @csrf
            <div class="rating_input">
                <label>Értékelésed:</label>
                <div class="star_rating">
                    @for($i = 10; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                        <label for="star{{ $i }}">★</label>
                    @endfor
                </div>
            </div>
            
            <textarea name="content" placeholder="Írd le a véleményed a filmről..." required></textarea>
            <button type="submit" class="btn btn--primary">Küldés</button>
        </form>
    @else
        <div class="login_prompt">
            <p><a href="{{ route('login') }}">Jelentkezz be</a> az értékeléshez!</p>
        </div>
    @endauth

    <div class="reviews_list">
        
            <div class="review_item">
                <div class="review_user">
                    <div class="user_avatar"></div>
                    <div class="user_info">
                        <strong>name</strong>
                        <span>time</span>
                    </div>
                    <div class="user_rating">⭐ ??/10</div>
                </div>
                <p class="review_text">content</p>
            </div>
        
            <p class="no_reviews">Még nincs értékelés. Legyél te az első!</p>
        
    </div>
</section>

<div class="related_movies_section reveal">
    <h2>Hasonló filmek</h2>
    <div class="grid">
        @foreach($related as $relatedMovie)
            @include('components.movie-card', ['movie' => $relatedMovie])
        @endforeach
    </div>
</div>
@endsection