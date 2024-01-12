<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoginService;
use App\Models\User;

class AuthController extends Controller
{
    
    
    private $loginService;
     
    /**
    * コンストラクタ
    */
    public function __construct(LoginService $LoginService)
    {
        $this->loginService = $LoginService;
    }
    
    
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

        if ($this->loginService->login($request->email, $request->password)) {
            $request->session()->regenerate();
            // タスクボード一覧ページへ遷移
            return redirect('/taskboards'); // ここにリダイレクト先を指定
        }

        return back()->withErrors([
            'login' => true,
        ])->onlyInput('login');
    }

    /**
     * ユーザーのログアウトを処理します。
     */
    public function logout(Request $request)
    {
        $this->loginService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // ログアウト後のリダイレクト先
    }
}
