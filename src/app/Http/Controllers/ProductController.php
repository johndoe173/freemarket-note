<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // 商品一覧ページ
   public function index(Request $request)
{
    $tab = $request->query('tab', 'recommend');
    $search = $request->query('search');

    if ($tab === 'mylist' && Auth::check()) {
        $query = Product::whereHas('likes', function ($query) {
            $query->where('user_id', Auth::id());
        });
    } else {
        $query = Product::where('user_id', '!=', Auth::id());
        $tab = 'recommend';
    }

    if (!empty($search)) {
        $query->where('name', 'LIKE', "%{$search}%");
    }

    $products = $query->get();

    return view('index', compact('products', 'tab', 'search'));
    }

    // 商品詳細ページ
    public function show($item_id)
    {
        // IDに基づいて商品情報を取得
        $product = Product::with(['categories', 'likes', 'comments.user'])->findOrFail($item_id);

        return view('show', compact('product'));
    }

        /**
     * 商品出品ページを表示
     */
    public function create()
    {
        return view('create');
    }

    /**
     * 商品情報を保存
     */
    public function store(Request $request)
    {
        // 🔹 バリデーション
        $request->validate([
            'category' => 'nullable|array',
            'category.*' => 'string|max:255',
            'condition' => 'required|string|in:new,used,other',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 🔹 画像アップロード処理
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // `storage/app/public/products/` に保存
        }

    
        // 🔹 `category` のデフォルト値を `[]` に設定
        $category = $request->category ? json_encode($request->category) : json_encode([]);

        // 🔹 商品情報をデータベースに保存
        $product = Product::create([
            'user_id' => Auth::id(),
            'category' => $category,
            'condition' => $request->condition,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('mypage', ['page' => 'list'])->with('success', '商品を出品しました！');
    }
}
