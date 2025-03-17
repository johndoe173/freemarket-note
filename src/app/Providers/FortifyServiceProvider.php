<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        // 🔹 会員登録時の処理
        Fortify::createUsersUsing(CreateNewUser::class);

        // 🔹 ログインフォームのカスタマイズ
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 🔹 Fortify のカスタムバリデーションメッセージを適用
        Fortify::authenticateUsing(function (Request $request) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ], [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => '有効なメールアドレスを入力してください',
                'password.required' => 'パスワードを入力してください',
                'password.min' => 'パスワードは8文字以上で入力してください',
            ]);

            // 🔹 ユーザー認証処理
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => 'ログイン情報が登録されていません。',
                ]);
            }

            if (!$user->hasVerifiedEmail()) {
                throw ValidationException::withMessages([
                    'email' => 'メール認証が完了していません。メールを確認してください。',
                ]);
            }

            return $user;
        });
    }
}
