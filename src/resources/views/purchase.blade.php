@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<form method="POST" action="{{ route('purchase.store') }}">
@csrf
<input type="hidden" name="product_id" value="{{ $product->id }}">

<div class="purchase">
    <!-- 🔹 左カラム -->
    <div class="purchase__left">
        <h2 class="purchase__title">商品購入</h2>

        <div class="purchase__item">
            <div class="purchase__item-image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
            </div>
            <div class="purchase__item-info">
                <p class="purchase__item-name">{{ $product->name }}</p>
                <p class="purchase__item-price">¥{{ number_format($product->price) }}</p>
            </div>
        </div>

        <div class="purchase__payment">
            <h3>支払い方法</h3>
            <select name="payment_method" required>
                <option value="">選択してください</option>
                <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>クレジットカード</option>
                <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
            </select>
        </div>

        <div class="purchase__address">
            <h3>配送先 <a href="{{ route('purchase.address.edit', ['item_id' => $product->id]) }}" class="purchase__address-edit">変更する</a></h3>
            <p>〒 {{ Auth::user()->zipcode }}</p>
            <p>{{ Auth::user()->address }}</p>
            <p>{{ Auth::user()->building ?? '（建物名なし）' }}</p>
        </div>
    </div>

    <!-- 🔹 右カラム（ボックス）-->
    <div class="purchase__right">
        <div class="purchase__summary">
            <h3>注文内容</h3>
            <p>商品代金 <span class="purchase__summary-price">¥{{ number_format($product->price) }}</span></p>

            @php
                $payment_text = '選択してください';
                if (old('payment_method') == 'credit') {
                    $payment_text = 'クレジットカード';
                } elseif (old('payment_method') == 'convenience') {
                    $payment_text = 'コンビニ払い';
                }
            @endphp

            <p>支払い方法 <span class="purchase__summary-method">{{ $payment_text }}</span></p>

            <!-- ✅ このボタンは form 内にあるため送信される -->
            <button type="submit" class="purchase__button">購入する</button>
        </div>
    </div>
</div>
</form>
@endsection