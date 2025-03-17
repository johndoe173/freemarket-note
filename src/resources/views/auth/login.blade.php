@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <div class="login-form__heading">
        <h2>ログイン</h2>
    </div>

    <form class="form" action="{{ route('login') }}" method="post">
        @csrf
        <div class="login__form-group">
            <label class="login__label" for="email">メールアドレス</label>
            <input class="login__input" type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="login__form-group">
            <label class="login__label" for="password">パスワード</label>
            <input class="login__input" type="password" id="password" name="password">
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="login__button">ログインする</button>
    </form>

    <a href="{{ route('register') }}" class="login__register-link">会員登録はこちら</a>
</div>
@endsection

