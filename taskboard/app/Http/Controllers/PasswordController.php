<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail; // 作成するメールクラス

class PasswordController extends Controller
{
    
    private $UserService;
    
    /*
    * コンストラクタ
    */
    public function __construct(UserServiceInterface $UserService)
    {
        $this->UserService = $UserService;
    }
    
    
      
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
            'password' => 'required',
            'password2' => 'required|same:password',
        ]);
        
        // パスワード更新処理
        $flag = $this->UserService->changePassword($request->password);
        
        
        if($flag) {
            $data = [
            'message' => 'パスワード更新完了しました。',
            'link' => 'taskboards.index',
            'button' => 'タスクボード一覧ページ'
            ];
        } else {
            $data = [
            'message' => 'パスワードが更新されませんでした。',
            'link' => 'taskboards.index',
            'button' => 'タスクボード一覧ページ'
            ];
        }

        return view('base.complete', $data);
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
