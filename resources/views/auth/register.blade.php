@extends('layouts.app')

@section('title', 'Criticly – Regisztráció')

@section('content')
    <div class="auth_wrapper reveal">
        <div class="auth_box">
            <div class="auth_head">
                <h1>Csatlakozz!</h1>
                <p>Legyél te is a közösség tagja.</p>
            </div>

            <form class="auth_form" action="{{ route('user.register') }}" method="POST">
                @csrf
                <div class="form_group">
                    <label for="name" class="form_label">Felhasználónév</label>
                    <input type="text" id="name" name="name" class="form_input" placeholder="Pl. MovieBuff99" required
                        autofocus>
                    @error('name')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form_group">
                    <label for="email" class="form_label">Email cím</label>
                    <input type="email" id="email" name="email" class="form_input" placeholder="hello@criticly.com"
                        required>
                    @error('email')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form_group">
                    <label for="password" class="form_label">Jelszó</label>
                    <input type="password" id="password" name="password" class="form_input" placeholder="Minimum 8 karakter"
                        required>
                </div>

                <div class="form_group">
                    <label for="password_confirmation" class="form_label">Jelszó újra</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form_input"
                        placeholder="Jelszó megerősítése" required>
                    @error('password')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn--primary auth_btn">Regisztráció</button>
            </form>

            <div class="auth_footer">
                <p>Már van fiókod? <a href="{{ route('login') }}">Lépj be itt</a></p>
            </div>
        </div>
    </div>
@endsection