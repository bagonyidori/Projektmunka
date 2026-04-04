@extends('layouts.app')

@section('title', 'Criticly – Filmek')

@section('content')
<section class="page_header reveal">
    <div>
        <h1>Filmek</h1>
        <p>Szűrj, keress és fedezz fel új kedvenceket.</p>
    </div>

    <div class="filters">
        <a href="{{ route('movies.index') }}" class="chip {{ !request('genre') ? 'is_active' : '' }}">Összes</a>  
        <a href="{{ route('movies.index', ['genre' => 'Action']) }}" class="chip {{ request('genre') == 'Action' ? 'is_active' : '' }}">Akció</a>
        <a href="{{ route('movies.index', ['genre' => 'Comedy']) }}" class="chip {{ request('genre') == 'Comedy' ? 'is_active' : '' }}">Vígjáték</a>
        <a href="{{ route('movies.index', ['genre' => 'Drama']) }}" class="chip {{ request('genre') == 'Drama' ? 'is_active' : '' }}">Dráma</a>
        <a href="{{ route('movies.index', ['genre' => 'Sci-Fi']) }}" class="chip {{ request('genre') == 'Sci-Fi' ? 'is_active' : '' }}">Sci-Fi</a>
        <a href="{{ route('movies.index', ['genre' => 'Horror']) }}" class="chip {{ request('genre') == 'Horror' ? 'is_active' : '' }}">Horror</a>
        <a href="{{ route('movies.index', ['genre' => 'Romance']) }}" class="chip {{ request('genre') == 'Romance' ? 'is_active' : '' }}">Romantikus</a>
        <a href="{{ route('movies.index', ['genre' => 'Fantasy']) }}" class="chip {{ request('genre') == 'Fantasy' ? 'is_active' : '' }}">Fantasy</a>
    </div>
</section>

<section class="grid" id="catalogGrid">
    @foreach($movies as $movie)
            @include('components.movie-card', ['movie' => $movie])
    @endforeach
</section>

<div class="pagination_wrapper">
    <div class="pagination_info">
        Oldal: {{ $movies->currentPage() }} / {{ $movies->lastPage() }}
    </div>
    {{ $movies->links() }}
</div>
@endsection
