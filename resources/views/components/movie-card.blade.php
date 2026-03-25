<a href="{{ route('movies.show', $movie->id) }}" class="movie_card" data-genre="{{ strtolower($movie->genre) }}">
    @if($movie->poster)
        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}">
    @else
        <div class="poster_placeholder">Nincs kép</div>
    @endif
    
    <div class="card_content">
        <h3>{{ $movie->title }}</h3>
        
        <div class="card_meta">
            <span class="year">{{ date('Y', strtotime($movie->releaseDate)) }}</span>
            <span class="genre_label">{{ $movie->genre }}</span>
        </div>
    </div>
</a>