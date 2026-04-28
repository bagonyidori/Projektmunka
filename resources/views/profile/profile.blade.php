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
                <div class="expandable_container">
                    <div class="grid">
                        @foreach ($favorites as $favorite)
                            <div class="profile_item">
                                <a href="{{ route('movies.show', $favorite->id) }}" class="profile_link">
                                    <h3>{{ $favorite->title }}</h3>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if(count($favorites) > 6)
                    <button class="show_more_btn">Összes megjelenítése</button>
                @endif
            </section>

            <section class="profile_section reveal">
                <h2>Saját értékeléseid</h2>
                <div class="expandable_container">
                    <div class="my_review_list">
                        @foreach ($user->ratings as $rating)
                            <div class="profile_item">
                                <a href="{{ route('movies.show', $rating->movie->id) }}" class="profile_link">
                                    <h3>{{ $rating->movie->title }} - {{ $rating->stars }}</h3>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if(count($user->ratings) > 6)
                    <button class="show_more_btn">Összes megjelenítése</button>
                @endif
            </section>
        </div>
    </div>
@endsection