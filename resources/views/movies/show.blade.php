@extends('layouts.app')

@section('content')
    <div class="movie_detail_wrapper reveal">
        <a href="{{ route('home') }}" class="btn back_btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
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
                <h1 class="movie_title">{{ $movie->title }}</h1>

                <div class="movie_badges">
                    <span class="badge">{{ date('Y/m/d', strtotime($movie->releaseDate)) }}</span>
                    <span class="badge">{{ $movie->genre }}</span>
                    <span class="badge badge--rating">
                        {{ number_format($average_rating, 1) }}
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px; height:14px; margin-right:4px;">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                        </svg>
                    </span>
                </div>

                <div class="movie_plot">
                    <h3>Történet</h3>
                    <p class="movie_plot_text">{{ $movie->plot }}</p>
                </div>

                <div class="platform_grid">
                    @php 
                        $platforms = [
                            'netflix' => 'Netflix', 
                            'disney' => 'Disney+', 
                            'hbo' => 'HBO Max', 
                            'apple' => 'Apple TV', 
                            'amazon' => 'Amazon'
                        ];
                        $votes = $movie->streamingVotes;
                        $verified = $votes ? $votes->verified_platform : null;
                    @endphp

                    @foreach($platforms as $slug => $label)
                        <button class="platform_btn {{ !auth()->check() ? 'guest-btn' : '' }} {{ $verified === $slug ? 'is-verified' : '' }}" 
                            data-platform="{{ $slug }}" 
                            data-movie-id="{{ $movie->id }}">

                            @if($verified === $slug)
                                <span class="verified_badge" title="Admin által hitelesítve">
                                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:12px; height:12px;">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                </span>
                            @endif

                            <span class="platform_name">{{ $label }}</span>
                            <span class="vote_count">{{ $votes ? $votes->$slug : 0 }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="movie_actions">
                    <form action="{{ auth()->check() ? route('movie.favourite', ['id' => $movie->id]) : '#' }}" method="POST">
                        @csrf
                        <button id="favBtn" class="btn favBtn btn--primary {{ $movie->is_favorite ? 'is_active' : '' }} {{ !auth()->check() ? 'guest-fav-btn' : ''}}"
                            data-id="{{ $movie->id }}"
                            type="{{ auth()->check() ? 'submit' : 'button' }}">
                            <svg class="favBtn-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                            {{ $movie->is_favorite ? 'Eltávolítás' : 'Kedvencekhez' }}
                        </button>
                    </form>

                    <button id="shareBtn" class="btn btn--ghost">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                            <polyline points="16 6 12 2 8 6"></polyline>
                            <line x1="12" y1="2" x2="12" y2="15"></line>
                        </svg>
                        Megosztás
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="movie_trailer_section reveal">
        <h2>Előzetes</h2>
        <div class="trailer_wrapper">
            @if($movie->trailerUrl)
                @php
                    $videoId = null;
                    
                    $urlParts = parse_url($movie->trailerUrl);
                    if (isset($urlParts['query'])) {
                        parse_str($urlParts['query'], $queryParams);
                        $videoId = $queryParams['v'] ?? null;
                    }
                    
                    if (!$videoId && isset($urlParts['path'])) {
                        $videoId = ltrim($urlParts['path'], '/');
                    }
                @endphp

                @if($videoId && strlen($videoId) === 11)
                    <div class="video_container">
                        <iframe 
                            src="https://www.youtube.com/embed/{{ $videoId }}?rel=0" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <div class="no_trailer_box">
                        <p>Nem sikerült feldolgozni a videót.</p>
                        <small style="opacity: 0.5;">Azonosító: {{ $videoId ?? 'Nem található' }}</small>
                    </div>
                @endif
            @else
                <div class="no_trailer_box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M2 8a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z" />
                        <line x1="2" y1="2" x2="22" y2="22" stroke="var(--primary)" />
                    </svg>
                    <p>Ehhez a filmhez jelenleg nem érhető el előzetes.</p>
                </div>
            @endif
        </div>
    </div>

    <section class="movie_reviews reveal">
        <div class="section_header">
            <h2>Vélemények</h2>
            <span class="review_count"> {{ count($ratings) }} hozzászólás</span>
            <span class="review_average">Átlagosan: {{ number_format($average_rating, 1) }} ⭐</span>
        </div>

        @auth
            <form action="{{ route('rating.create', ["id" => $movie->id]) }}" method="POST" class="review_form">
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
                <textarea name="content" placeholder="Írd le a véleményed a filmről..."></textarea>
                <button type="submit" class="btn btn--primary">Küldés</button>
            </form>
        @else
            <div class="login_prompt">
                <button class="btn btn--primary"><p><a href="{{ route('login') }}">Jelentkezz be az értékeléshez!</a></p></button>
            </div>
            <br>
        @endauth

        <div class="reviews_list">
            @forelse ($ratings as $rating)
                <div class="review_item">
                    <div class="review_user">
                        <div class="user_info">
                            <strong class="review_user_name">{{ $rating->user->name }}</strong>
                            <span>{{$rating->created_at->format('Y-m-d')}}</span>
                        </div>
                        <div class="user_rating">⭐ {{ $rating->stars }}/10</div>
                    </div>
                    <p class="review_text">{{$rating->comment}}</p>
                </div>
            @empty
                <p class="no_reviews">Még nincs értékelés. Legyél te az első!</p>
            @endforelse
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