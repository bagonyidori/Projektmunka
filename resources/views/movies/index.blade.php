@extends('layouts.app')

@section('title', 'Criticly – Filmek')

@section('content')
<section class="page_header reveal">
    <div>
        <h1>Filmek</h1>
        <p>Szűrj, keress és fedezz fel új kedvenceket.</p>
    </div>

    <div class="filters">
        <button class="chip filter_btn is_active" data-filter="all">Összes</button>
        <button class="chip filter_btn" data-filter="action">Akció</button>
        <button class="chip filter_btn" data-filter="horror">Horror</button>
        <button class="chip filter_btn" data-filter="sci-fi">Sci-fi</button>
        <button class="chip filter_btn" data-filter="comedy">Vígjáték</button>
        <button class="chip filter_btn" data-filter="drama">Dráma</button>
        <button class="chip filter_btn" data-filter="romance">Romantikus</button>
        <button class="chip filter_btn" data-filter="fantasy">Fantasy</button>
    </div>
</section>

<section class="grid" id="catalogGrid">
    @foreach($movies as $movie)
            @include('components.movie-card', ['movie' => $movie])
    @endforeach
</section>

<div class="pagination_wrap">
    {{ $movies->links() }}
</div>
@endsection
