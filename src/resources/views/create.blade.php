@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
    <div class="product-create">
        <h2 class="product-create__title">商品の出品</h2>
        
        <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data" class="product-create__form">
            @csrf

            <!-- 🔹 商品画像 -->
            <h3>商品画像</h3>
            <div class="product-create__image">
                <label for="image">商品画像</label>
                <input type="file" id="image" name="image" accept="image/*" onchange="this.nextElementSibling.querySelector('img').src = window.URL.createObjectURL(this.files[0]); this.nextElementSibling.querySelector('img').style.display = 'block';">
                <div class="product-create__preview-container">
                    <img id="image-preview" class="product-create__preview" style="display: none; max-width: 100%; height: auto;">
                </div>
            </div>

            <!-- 🔹 商品の詳細 -->
            <div class="product-create__details">
                <h3 class="product-create__h3title">商品の詳細</h3>

                <!-- 🔹 カテゴリ（ボタン風UI） -->
                <label class="product-create__label" for="category">カテゴリー</label>
                <div class="product-create__categories">
                    @foreach (['ファッション', '家電', 'インテリア', 'レジャー', 'メンズ', 'レディース', 'コスメ', '本', 'ゲーム', 'スポーツ', 'おもちゃ', 'ベビー・キッズ'] as $category)
                        <label class="category-button">
                            <input type="checkbox" name="categories[]" value="{{ $category }}">
                            {{ $category }}
                        </label>
                    @endforeach
                </div>

                <!-- 🔹 商品の状態 -->
                <label class="product-create__label" for="condition">商品の状態</label>
                <select id="condition" name="condition">
                    <option value="">選択してください</option>
                    <option value="good">良好</option>
                    <option value="minor_damage">目立った傷や汚れなし</option>
                    <option value="moderate_damage">やや傷や汚れあり</option>
                    <option value="bad">状態が悪い</option>
                </select>

                <h3 class="product-create__h3title">商品名と説明</h3>
                <!-- 🔹 商品名 -->
                <label class="product-create__label" for="name">商品名</label>
                <input type="text" id="name" name="name" placeholder="商品名を入力">

                <!-- 🔹 商品の説明 -->
                <label class="product-create__label" for="description">商品の説明</label>
                <textarea id="description" name="description" placeholder="商品の説明を入力"></textarea>

                <!-- 🔹 販売価格 -->
                <label class="product-create__label" for="price">販売価格</label>
                <input type="number" id="price" name="price" placeholder="¥">
            </div>

            <button type="submit" class="product-create__submit">出品する</button>
        </form>
    </div>
@endsection
