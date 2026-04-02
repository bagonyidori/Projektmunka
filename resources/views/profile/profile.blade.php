@extends('layouts.app')

@section('content')
<div class="page_shell">
    <div class="profile_header reveal">
        <div class="user_large_avatar">
            {{substr(Auth::user()->name, 0, 1) }}
        </div>
        <h1>Üdv, {{ Auth::user()->name }}!</h1>
        <p>Tag mióta: {{ Auth::user()->created_at->format('Y. M. d.') }}</p>
    </div>

    <div class="profile_grid">
        <section class="profile_section reveal">
            <h2>Kedvenc filmjeid</h2>
            <div class="grid">
                @forelse($favoriteMovies as $movie)
                    @include('components.movie-card', ['movie' => $movie])
                @empty
                    <p>Nincsenek kedvenc filmjeid. Fedezz fel újakat a <a href="{{ route('movies.index') }}">filmek között</a>!</p>
                @endforelse
            </div>
        </section>

        <section class="profile_section reveal">
            <h2>Saját értékeléseid</h2>
            <div class="my_review_list">
                @forelse($myReviews as $review)
                    <div class="my_review_card">
                        <strong>{{ $review->movie->title }}</strong>
                        <p>{{ $review->content }}</p>
                        <span class="rating">⭐ {{ $review->rating }}/10</span>
                    </div>
                    <small>{{ $review->created_at->format('Y. M. d.') }}</small>
                    <p>{{ $review->content }}</p>
                @empty
                    <p>Nem írtál még értékelést. Oszd meg véleményed a filmekről!</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection