<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail; // 作成するメールクラス

class PasswordController extends Controller
{
    /**
     * パスワード変更画面を表示します。
     */
    public function change()
    {
        return view('password.change');
    }

    /**
     * パスワードの変更を処理します。
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => '現在のパスワードが正しくありません。']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('password.change')->with('success', 'パスワードが変更されました。');
    }

    /**
     * パスワードの再発行を処理します。
     */
    public function reset(Request $request, $id)
    {
        // 対象のユーザーを取得
        $user = User::find($id);
        if (!$user) {
            return back()->withErrors(['error' => 'ユーザーが見つかりません。']);
        }

        // 新しいランダムパスワードを生成
        $newPassword = \Str::random(10);

        // ユーザーのパスワードを更新
        $user->password = Hash::make($newPassword);
        $user->save();

        // パスワード再発行用のメールを送信
        Mail::to($user->email)->send(new PasswordResetMail($newPassword));

        return back()->with('success', '新しいパスワードをユーザーのメールアドレスに送信しました。');
    }
}
