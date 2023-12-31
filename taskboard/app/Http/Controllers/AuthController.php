<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * ログイン画面を表示します。
     */
    public function showLogin()
    {
        // ここにログイン画面表示の処理を記述
        return view('auth.login');
    }

    /**
     * ユーザーのログインを処理します。
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard'); // ここにリダイレクト先を指定
        }

        return back()->withErrors([
            'email' => '指定された資格情報が記録と一致しません。',
        ])->onlyInput('email');
    }

    /**
     * ユーザーのログアウトを処理します。
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // ログアウト後のリダイレクト先
    }
}
