@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
    <div class="product-detail">
        <div class="product-detail__image">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        </div>

        <div class="product-detail__info">
            <h2 class="product-detail__title">{{ $product->name }}</h2>
            <p class="product-detail__brand">{{ $product->brand ?? 'ブランド不明' }}</p>
            <p class="product-detail__price">¥{{ number_format($product->price) }} <span>（税込）</span></p>

            <!-- いいねボタン -->
<div class="product-detail__icons">
    @auth
        <form action="{{ route('like.toggle', ['item_id' => $product->id]) }}" method="POST" class="like-form">
            @csrf
            <button type="submit" class="like-button">
                <span class="like-icon {{ $product->likes->where('user_id', Auth::id())->count() ? 'liked' : '' }}">
                    ★
                </span>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="like-button">
            ★
        </a>
    @endauth
    <span class="product-detail__likes">{{ $product->likes->count() }}</span>
    <span class="product-detail__comments-icon">💬 {{ $product->comments->count() }}</span>
</div>

            <!-- 購入手続きボタン -->
            <a href="{{ route('purchase.show', ['item_id' => $product->id]) }}" class="product-detail__buy-button">
                購入手続きへ
            </a>

            <div class="product-detail__description">
                <h3>商品説明</h3>
                <p>{{ $product->description }}</p>
            </div>

            <div class="product-detail__info-extra">
                <h3>商品の情報</h3>
                <p>カテゴリー：
                    @foreach ($product->categories as $category)
                        <span class="category-tag">{{ $category->name }}</span>
                    @endforeach
                </p>
                <p>商品の状態：<span class="product-condition">{{ $product->condition }}</span></p>
            </div>

            <!-- コメント -->
            <div class="product-detail__comments">
                <h3>コメント ({{ $product->comments->count() }})</h3>

                @forelse ($product->comments as $comment)
                    <div class="product-detail__comment">
                        <span class="comment-user-icon">{{ substr($comment->user->name, 0, 1) }}</span>
                        <span class="comment-username">{{ $comment->user->name }}</span>
                        <p class="comment-text">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p>まだコメントはありません。</p>
                @endforelse

                @auth
                    <form action="{{ route('comment.store', ['item_id' => $product->id]) }}" method="POST">
                        @csrf
                        <textarea class="product-detail__textarea" name="content" placeholder="商品へのコメント" required maxlength="255"></textarea>
                        @error('content')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="product-detail__comment-button">コメントを送信する</button>
                    </form>
                @else
                    <p>コメントを投稿するには<a href="{{ route('login') }}">ログイン</a>してください。</p>
                @endauth
            </div>
        </div>
    </div>
@endsection