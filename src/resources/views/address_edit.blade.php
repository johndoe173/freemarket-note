@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="address-edit">
        <h2 class="address-edit__title">住所の変更</h2>
        <form method="POST" action="{{ route('purchase.address.update', ['item_id' => $item_id]) }}">
            @csrf
            
            <div class="address-edit__group">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" placeholder="郵便番号を入力">
            </div>

            <div class="address-edit__group">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old ('address', $user->address) }}" placeholder="住所を入力">
            </div>

            <div class="address-edit__group">
                <label for="building">建物名（任意）</label>
                <input type="text" name="building" id="building" value="{{ old('building', $user->building) }}" placeholder="建物名を入力">
            </div>

            <button class="address-edit__button" type="submit">更新する</button>
        </form>
    </div>
@endsection