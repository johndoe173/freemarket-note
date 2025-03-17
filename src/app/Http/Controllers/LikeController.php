<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Product;

class LikeController extends Controller
{
    public function toggle($item_id)
    {
        if (!Auth::check()) {
            return redirect()->route('product.show', ['item_id' => $item_id])->with('error', 'ログインが必要です');
        }

        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        $like = Like::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($like) {
            // いいね解除
            $like->delete();
        } else {
            // いいね追加
            Like::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        return redirect()->route('product.show', ['item_id' => $item_id]);
    }
}