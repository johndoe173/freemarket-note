<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔹 ログイン & 会員登録
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// 🔹 メール認証
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/mypage/profile'); 
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '確認メールを再送しました。');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// 🔹 未認証ユーザーのアクセス制限（認証 & メール認証必須）
Route::middleware(['auth', 'verified'])->group(function () {
    // マイページ
    Route::get('/mypage', [UserController::class, 'show'])->name('mypage');

    // プロフィール編集
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 🔹 商品出品ページ表示
    Route::get('/sell', [ProductController::class, 'create'])->name('product.create');

    // 🔹 商品出品処理
    Route::post('/sell', [ProductController::class, 'store'])->name('product.store');

    // いいね登録・解除
    Route::post('/like/{item_id}', [LikeController::class, 'toggle'])->name('like.toggle');

    // コメント投稿
    Route::post('/comment/{item_id}', [CommentController::class, 'store'])->name('comment.store');

    // 🔹 購入関連
    // 購入画面表示（購入する商品を取得）
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
    // 購入処理（購入ボタンを押した際に実行）
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');

    // 住所変更画面の表示
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');

    // 住所の更新処理
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

    // プロフィールページ - 購入履歴
    Route::get('/mypage/purchases', [ProfileController::class, 'purchases'])->name('profile.purchases');

});

// 🔹 認証不要（全ユーザーがアクセス可能）
Route::get('/', [ProductController::class, 'index'])->name('products.index'); // 商品一覧
Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('product.show'); // 商品詳細
