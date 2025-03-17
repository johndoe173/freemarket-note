<!-- resources/views/layouts/app?auth.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/common_auth.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__logo">
            <img src="{{ asset('images/logo.svg') }}" alt="COACHTECH ロゴ" class="header__logo-image">
        </div>
    </header>
    <main>
    @yield('content')
    </main>
</body>
</html>