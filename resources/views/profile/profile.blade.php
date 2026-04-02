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
                
            </div>
        </section>

        <section class="profile_section reveal">
            <h2>Saját értékeléseid</h2>
            <div class="my_review_list">
                
            </div>
        </section>
    </div>
</div>
@endsection