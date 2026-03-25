<a href="{{ route('movies.show', $movie->id) }}" class="movie_card">
    @if($movie->poster)
        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}">
    @else
        <div class="poster_placeholder">Nincs kép</div>
    @endif
    
    <div class="card_content">
        <h3>{{ $movie->title }}</h3>
        <div class="card_meta">
            <span>{{ date('Y', strtotime($movie->releaseDate)) }}</span>
            <span>{{ $movie->genre }}</span>
        </div>
    </div>
</a>