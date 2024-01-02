<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Taskboard;
use App\Models\User;
use App\Models\TaskboardUser;

class TaskBoardController extends Controller
{
    /**
     * タスクボード一覧を表示します。
     */
    public function index()
    {
        $taskboards = Taskboard::all();
        return view('taskboards.index', compact('taskboards'));
    }

    /**
     * タスクボード新規作成画面を表示します。
     */
    public function create()
    {
        $users = User::all();
        return view('taskboards.create', compact('users'));
    }

    /**
     * 新しいタスクボードを保存します。
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array',
        ]);
        
        // Authユーザー取得
        $id = Auth::user()->userId;
        
        $taskboard = new Taskboard();
        $taskboard->taskboardName = $request->name;
        $taskboard->creatorId = $id;
        $taskboard->updaterId = $id;
        $taskboard->save();

        // タスクボードにユーザーを割り当てる
        $users = $request->users;
        foreach($users as $user) {
            $taskboardUsers = new TaskboardUser();
            $taskboardUsers->taskboardId = $taskboard->taskboardId;
            $taskboardUsers->userId = $user;
            $taskboardUsers->creatorId = $id;
            $taskboardUsers->updaterId = $id;
            $taskboardUsers->save();
        }
        

        return redirect()->route('taskboards.index')->with('success', '新しいタスクボードが作成されました。');
    }

    /**
     * タスクボードの編集画面を表示します。
     */
    public function edit($id)
    {
        $taskboard = Taskboard::findOrFail($id);
        
        // タスクボードの利用者一覧を取得
        $taskboardUsers = TaskboardUser::where('taskboardId')->get();
        $userList = array(); // ユーザ一覧を格納する配列
        foreach($taskboardUsers as $taskboardUser) {
            $userList[] = $taskboardUser->userId;
        }
        
        
        
        $users = User::all();
        return view('taskboards.edit', compact('taskboard', 'users', 'userList'));
    }

    /**
     * タスクボードの更新を処理します。
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array',
        ]);
        
        // Authユーザー取得
        $id = Auth::user()->userId;

        $taskboard = Taskboard::findOrFail($id);
        $taskboard->taskboardName = $request->name;
        $taskboard->updaterId = $id;
        $taskboard->save();

        // タスクボードにユーザーを割り当てる
        $taskboard->users()->sync($request->users);

        return redirect()->route('taskboards.index')->with('success', 'タスクボードが更新されました。');
    }

    /**
     * タスクボードを削除します。
     */
    public function destroy($id)
    {
        $taskboard = Taskboard::findOrFail($id);
        $taskboard->delete();

        return redirect()->route('taskboards.index')->with('success', 'タスクボードが削除されました。');
    }
}