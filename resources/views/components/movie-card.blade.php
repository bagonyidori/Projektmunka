<a href="{{ route('movies.show', $movie->id) }}" class="card reveal">
    <div class="card_wrap">
        <img class="card_img" src="{{ $movie->poster ?? asset('images/placeholder.jpg') }}" alt="{{ $movie->title }}">
        <div class="card_over"></div>
        <div class="card_meta_box">
            <span class="pill">{{ $movie->year ?? '—' }}</span>
            <span class="pill pill--rating">★ {{ $movie->rating ?? 'N/A' }}</span>
        </div>
    </div>
    <div class="card_body">
        <h3>{{ $movie->title }}</h3>
        <p>{{ $movie->description }}</p>
    </div>
</a>