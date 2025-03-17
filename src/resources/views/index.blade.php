<!-- 商品一覧ページ -->
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection

@section('content')
    <main class="products">
        <!-- タブメニュー -->
        <ul class="products__tabs">
            <li class="products__tab">
                <a href="{{ url('/') }}?tab=recommend&search={{ request('search', '') }}" 
                   class="products__tab-link {{ $tab === 'recommend' ? 'products__tab-link--active' : '' }}">
                    おすすめ
                </a>
            </li>
            <li class="products__tab">
                <a href="{{ url('/') }}?tab=mylist&search={{ request('search', '') }}" 
                   class="products__tab-link {{ $tab === 'mylist' ? 'products__tab-link--active' : '' }}">
                    マイリスト
                </a>
            </li>
        </ul>

        <!-- 商品リスト -->
        <div class="products__list">
            @forelse ($products as $product)
                <div class="product-card">
                    <a href="{{ url('/item/' . $product->id) }}" class="product-card__link">
                        <div class="product-card__image">
                            <img src="{{ asset($product->image ? 'storage/' . $product->image : 'images/no-image.png') }}" 
                                 alt="{{ $product->name }}">
                            
                            @if ($product->is_sold)
                                <span class="product-card__sold-overlay">Sold</span>
                            @endif
                        </div>
                        <p class="product-card__name">{{ $product->name }}</p>
                        <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                    </a>
                </div>
            @empty
                <p>検索結果に一致する商品はありません。</p>
            @endforelse
        </div>
    </main>
@endsection
