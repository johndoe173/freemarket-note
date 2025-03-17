@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="profile">
        <h1 class="profile__title">プロフィール設定</h1>
        
        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" class="profile__form">
            @csrf

            <!-- プロフィール画像 -->
            <div class="profile__image-container">
                <div class="profile__image">
                <img id="avatar-preview" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}" 
                     alt="プロフィール画像" class="profile__image-preview">
                </div>
                <div class="profile__image-button-container">
                   <label for="avatar" class="profile__image-button">画像を選択する</label>
                <input type="file" id="avatar" name="avatar" class="profile__image-input" accept="image/*"
                    onchange="document.getElementById('avatar-preview').src = window.URL.createObjectURL(this.files[0]);">
                </div>
            </div>

            <!-- ユーザー名 -->
            <div class="profile__field">
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                @error('name') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- 郵便番号 -->
            <div class="profile__field">
                <label for="zipcode">郵便番号</label>
                <input type="text" id="zipcode" name="zipcode" value="{{ old('zipcode', $user->zipcode) }}" placeholder="例: 123-4567">
                @error('postal_code') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- 住所 -->
            <div class="profile__field">
                <label for="address">住所</label>
                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="例: 東京都新宿区〇〇">
                @error('address') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- 建物名 -->
            <div class="profile__field">
                <label for="building">建物名</label>
                <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}" placeholder="例: 〇〇マンション101号室">
                @error('building') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- 更新ボタン -->
            <button type="submit" class="profile__submit-button">更新する</button>
        </form>
    </div>
@endsection

