<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\UserServiceInterface;

class ProfileController extends Controller
{

    private $UserService;
    
    /*
    * コンストラクタ
    */
    public function __construct(UserServiceInterface $UserService)
    {
        $this->UserService = $UserService;
    }

    /*
     * ユーザー情報変更画面を表示します。
     */
    public function edit()
    {
        $user = $this->UserService->getLoginUser();
        
        $data = [
            'name' => $user['name'],
            'email'=> $user['email'],
        ];
        return view('profile.edit', $data);
    }

    /**
     * ユーザー情報の更新を処理します。
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);
        
        // ユーザー情報の更新
        $flag = $this->UserService->updateUser([
            'name'  => $request->name,
            'email' => $request->email
        ]);
    
        if($flag) {
            $message = '更新完了しました。';
        } else {
            $message = '更新失敗しました。';
        }
        
        // 更新完了ページの表示
        $data = [
            'message' => $message,
            'link' => 'taskboards.index',
            'button' => 'タスクボード一覧ページ'
        ];
        
        return view('base.complete', $data);
    }
}
