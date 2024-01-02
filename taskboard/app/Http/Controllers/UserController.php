<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * ユーザー一覧を表示します。
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * ユーザー新規作成画面を表示します。
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 新しいユーザーを保存します。
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $id = Auth::user()->userId;

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userType' => 0,
            'userStatus'=> 0,
            'creatorId' => $id,
            'updaterId' => $id
        ]);
        $user->save();

        return redirect()->route('users.index')->with('success', '新しいユーザーが作成されました。');
    }

    /**
     * ユーザー更新画面を表示します。
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * ユーザー情報の更新を処理します。
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'. $id . ',userId',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'ユーザー情報が更新されました。');
    }

    /**
     * ユーザーを削除します。
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'ユーザーが削除されました。');
    }
}
