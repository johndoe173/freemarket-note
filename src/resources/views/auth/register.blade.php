@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <div class="register-form__heading">
        <h2>会員登録</h2>
    </div>

    <form class="form" action="{{ route('register') }}" method="post">
        @csrf
        <div class="register__form-group">
            <label class="register__label" for="name">ユーザー名</label>
            <input class="register__input" type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="register__form-group">
            <label class="register__label" for="email">メールアドレス</label>
            <input class="register__input" type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="register__form-group">
            <label class="register__label" for="password">パスワード</label>
            <input class="register__input" type="password" id="password" name="password">
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="register__form-group">
            <label class="register__label" for="password_confirmation">確認用パスワード</label>
            <input class="register__input" type="password" id="password_confirmation" name="password_confirmation">
            @error('password_confirmation')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <p class="register__note">
            ※ 登録後、メール認証が必要です。メールに記載のリンクをクリックして認証を完了してください。
        </p>

        <button type="submit" class="register__button">登録する</button>
    </form>
    
    <a href="{{ route('login') }}" class="register__login-link">ログインはこちら</a>
</div>
@endsection
