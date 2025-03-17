<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
<header class="header">
    <div class="header__logo">
        <img src="{{ asset('images/logo.svg') }}" alt="COACHTECH ロゴ" class="header__logo-image">
    </div>
    <nav class="header__nav">
        <div class="header__center">
            <!-- 🔹 検索フォーム（中央配置） -->
            <form action="{{ route('products.index') }}" method="GET" class="header__search-form">
                <input type="text" name="search" class="header__search"
                       placeholder="なにをお探しですか？" value="{{ request('search') }}">
                <button type="submit" class="header__search-button">検索</button>
            </form>
        </div>
        
        <ul class="header__menu">
            @if(auth()->check())
                <!-- 🔹 ログインユーザー用メニュー -->
                <li><a href="{{ route('mypage') }}">マイページ</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="header__logout-form">
                        @csrf
                        <button type="submit" class="header__logout-button">ログアウト</button>
                    </form>
                </li>
                <li><a href="{{ route('product.create') }}" class="header__sell-button">出品</a></li>
            @else
                <!-- 🔹 未ログインユーザー用メニュー -->
                <li><a href="{{ route('login') }}">ログイン</a></li>
                <li><a href="{{ route('register') }}">会員登録</a></li>
            @endif
        </ul>
    </nav>
</header>
    <main>
    @yield('content')
    </main>
</body>
</html>

