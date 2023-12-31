<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * ユーザー情報変更画面を表示します。
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * ユーザー情報の更新を処理します。
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // 他のバリデーションルールが必要な場合はここに追加
        ]);

        $user->name = $request->name;
        // 他のフィールドの更新が必要な場合はここに追加
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'プロファイルが更新されました。');
    }
}
