@extends('layouts.app')

@section('title', 'Criticly – Filmek')

@section('content')
<section class="page_header reveal">
    <div>
        <h1>Filmek</h1>
        <p>Szűrj, keress és fedezz fel új kedvenceket.</p>
    </div>

    <div class="filters">
        <button class="chip is_active" data-filter="all">Összes</button>
        <button class="chip" data-filter="action">Akció</button>
        <button class="chip" data-filter="drama">Dráma</button>
        <button class="chip" data-filter="sci-fi">Sci-fi</button>
        <button class="chip" data-filter="comedy">Vígjáték</button>
    </div>
</section>

<section class="grid" id="catalogGrid">
    @foreach($movies as $movie)
        <article class="movie_card reveal" data-genre="{{ strtolower($movie->genre ?? 'all') }}">
            @include('components.movie-card', ['movie' => $movie])
        </article>
    @endforeach
</section>

<div class="pagination_wrap">
    {{ $movies->links() }}
</div>
@endsection
