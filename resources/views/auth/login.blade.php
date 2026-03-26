@extends('layouts.app')

@section('title', 'Criticly – Belépés')

@section('content')
    <div class="auth_wrapper reveal">
        <div class="auth_box">
            <div class="auth_head">
                <h1>Üdv újra!</h1>
                <p>Lépj be a fiókodba a folytatáshoz.</p>
            </div>

            <form class="auth_form" action="{{ route('user.login') }}" method="POST">
                @csrf
                <div class="form_group">
                    <label for="email" class="form_label">Email cím</label>
                    <input type="email" id="email" name="email" class="form_input" placeholder="hello@criticly.com" required
                        autocomplete="email" autofocus>
                </div>

                <div class="form_group">
                    <label for="password" class="form_label">Jelszó</label>
                    <input type="password" id="password" name="password" class="form_input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn--primary auth_btn">Belépés</button>
            </form>

            <div class="auth_footer">
                <p>Még nincs fiókod? <a href="{{ route('register') }}">Regisztrálj itt</a></p>
            </div>
        </div>
    </div>
@endsection