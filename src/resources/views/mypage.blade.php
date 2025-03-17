@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage">
        @if (session('success'))
            <p class="success-message">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        <!-- 🔹 プロフィール情報 -->
        <div class="mypage__header">
            <div class="mypage__image">
                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}" 
                     alt="プロフィール画像" class="mypage__image-preview">
            </div>
            <h2 class="mypage__username">{{ $user->name }}</h2>
            <a href="{{ route('profile.edit') }}" class="mypage__edit-button">プロフィールを編集</a>
        </div>

        <!-- 🔹 タブメニュー -->
        <ul class="mypage__tabs">
            <li class="mypage__tab">
                <a href="{{ url('/mypage?page=list') }}" class="mypage__tab-link {{ request('page', 'list') === 'list' ? 'mypage__tab-link--active' : '' }}">
                    出品した商品
                </a>
            </li>
            <li class="mypage__tab">
                <a href="{{ url('/mypage?page=buy') }}" class="mypage__tab-link {{ request('page') === 'buy' ? 'mypage__tab-link--active' : '' }}">
                    購入した商品
                </a>
            </li>
        </ul>

        <!-- 🔹 商品リスト -->
        <div class="products__list">
            @if (request('page', 'list') === 'list')
                @forelse ($listedProducts as $product)
                    <div class="product-card">
                        <a href="{{ route('product.show', ['item_id' => $product->id]) }}">
                            <div class="product-card__image">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            </div>
                            <p class="product-card__name">{{ $product->name }}</p>
                        </a>
                    </div>
                @empty
                    <p>出品した商品はありません。</p>
                @endforelse
            @else
                @forelse ($purchasedProducts as $product)
                    <div class="product-card">
                        <a href="{{ route('product.show', ['item_id' => $product->id]) }}">
                            <div class="product-card__image">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            </div>
                            <p class="product-card__name">{{ $product->name }}</p>
                        </a>
                    </div>
                @empty
                    <p>購入した商品はありません。</p>
                @endforelse
            @endif
        </div>
    </div>
@endsection

