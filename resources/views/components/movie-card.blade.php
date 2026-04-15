<a href="{{ route('movies.show', $movie->id) }}" class="movie_card" data-genre="{{ strtolower($movie->genre) }}">
    <div class="card_poster_wrapper">
        <img src="https://image.tmdb.org/t/p/original{{ $movie->poster }}" alt="{{ $movie->title }}">
        <div class="card_rating">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                </path>
            </svg>
            <span>{{ number_format($movie->average_rating ?? $movie->ratings_avg_stars ?? 0, 1) }}</span>
        </div>
    </div>

    <div class="card_content">
        <h3>{{ $movie->title }}</h3>
        <div class="card_meta">
            <span>{{ date('Y', strtotime($movie->releaseDate)) }}</span>
            <span class="genre_label">
                {{ implode(', ', array_slice(explode(',', $movie->genre), 0, 2)) }}
            </span>
        </div>
    </div>
</a>