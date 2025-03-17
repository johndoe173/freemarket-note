<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    /**
     * 購入ページの表示
     */
    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);

        // 既に売り切れている場合は購入できないようにする
        if ($product->is_sold) {
            return redirect()->route('products.index')->with('error', 'この商品は既に売り切れています。');
        }

        return view('purchase', compact('product'));
    }

    /**
     * 購入処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'payment_method' => 'required|in:credit,convenience',
        ]);

        $product = Product::findOrFail($request->product_id);

        // 商品が既に売り切れている場合はエラーを返す
        if ($product->is_sold) {
            return redirect()->back()->with('error', 'この商品は既に売り切れています。');
        }

        // 購入情報を保存
        Purchase::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'payment_method' => $request->payment_method,
        ]);

        // 商品を "sold" 状態にする
        $product->update(['is_sold' => true]);

        // 🔹 購入後の遷移先を「購入した商品」タブに設定
        return redirect()->route('mypage', ['page' => 'buy'])->with('success', '購入が完了しました！');
    }

    /**
     * 住所変更ページの表示
     */
    public function editAddress($item_id)
    {
        $user = Auth::user();
        return view('address_edit', compact('user', 'item_id'));
    }

    /**
     * 住所の更新処理
     */
    public function updateAddress(Request $request, $item_id)
    {
    $request->validate([
        'postal_code' => 'required|regex:/^\d{3}-\d{4}$/',
        'building' => 'nullable|string|max:255', // 建物名は任意入力
    ]);

    $user = Auth::user();
    $user->update([
        'postal_code' => $request->postal_code,
        'building' => $request->building,
    ]);

    return redirect()->route('purchase.show', ['item_id' => $item_id])->with('success', '住所が更新されました');
    }
}
