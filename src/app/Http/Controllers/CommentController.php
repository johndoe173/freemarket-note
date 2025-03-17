<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;
use App\Models\Product;

class CommentController extends Controller
{
    public function store(Request $request, $item_id)
    {
        // バリデーションルール
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.show', ['item_id' => $item_id])
                             ->withErrors($validator)
                             ->withInput();
        }

        if (!Auth::check()) {
            return redirect()->route('product.show', ['item_id' => $item_id])
                             ->with('error', 'ログインが必要です');
        }

        // コメントを保存
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $item_id,
            'content' => $request->content,
        ]);

        return redirect()->route('product.show', ['item_id' => $item_id]);
    }
}