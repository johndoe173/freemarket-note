<!-- resources/views/auth/verify.blade.php -->
@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify.css') }}">
@endsection

@section('content')
    <div class="verify">
        <p class="verify__message">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        <!-- 認証メールの確認ボタン -->
        <a href="http://localhost:8025/" target="_blank" class="verify__button">
            認証メールを確認する
        </a>

        <!-- 認証メールを再送するフォーム -->
        <form method="POST" action="{{ route('verification.send') }}" class="verify__resend-form">
            @csrf
            <button type="submit" class="verify__resend-button">認証メールを再送する</button>
        </form>

        @if (session('message'))
            <p class="verify__success-message">{{ session('message') }}</p>
        @endif
    </div>
@endsection
