<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // 🔹 バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'zipcode' => 'nullable|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 🔹 画像アップロード処理
        if ($request->hasFile('avatar')) {
            // 古い画像を削除
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // 新しい画像を `storage/app/public/profile_images/` に保存
            $imagePath = $request->file('avatar')->store('profile_images', 'public');

            // 画像のパスを保存
            $user->profile_image = $imagePath;
        }

        // 🔹 ユーザー情報を更新
        $user->update([
            'name' => $request->name,
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'building' => $request->building,
            'profile_image' => $user->profile_image ?? $user->getOriginal('profile_image'), // 画像がアップロードされていない場合は既存の画像を保持
        ]);

        // 🔹 成功メッセージ
        return redirect()->route('mypage')->with('success', 'プロフィールが更新されました');
    }

        public function purchases()
    {
        $user = Auth::user();
        $purchases = Purchase::where('user_id', $user->id)
            ->with('product') // 購入した商品の詳細情報も取得
            ->get();

        return view('profile.purchases', compact('purchases'));
    }
}
