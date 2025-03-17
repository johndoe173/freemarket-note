<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        // ログインしていない場合、ログインページへリダイレクト
        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインが必要です');
        }
        

        // 出品した商品
        $listedProducts = Product::where('user_id', $user->id)->get();

        // 購入した商品（購入テーブルがある前提）
        $purchasedProducts = $user->purchases()->with('product')->get()->pluck('product');

        // タブの切り替え
        $tab = $request->query('tab', 'listings');

        return view('mypage', compact('user', 'listedProducts', 'purchasedProducts', 'tab'));
    }

    public function mypage(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'list'); // デフォルトは「出品した商品」

        // ユーザーが出品した商品
        $listedProducts = Product::where('user_id', $user->id)->get();

        // ユーザーが購入した商品
        $purchasedProducts = Purchase::where('user_id', $user->id)
            ->with('product')
            ->get()
            ->pluck('product'); // `Purchase` モデルに `product()` のリレーションが必要

        return view('mypage', compact('user', 'listedProducts', 'purchasedProducts', 'page'));
    }
}
