<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taskboard;
use App\Models\User;

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

        $taskboard = new Taskboard();
        $taskboard->name = $request->name;
        $taskboard->save();

        // タスクボードにユーザーを割り当てる
        $taskboard->users()->sync($request->users);

        return redirect()->route('taskboards.index')->with('success', '新しいタスクボードが作成されました。');
    }

    /**
     * タスクボードの編集画面を表示します。
     */
    public function edit($id)
    {
        $taskboard = Taskboard::with('users')->findOrFail($id);
        $users = User::all();
        return view('taskboards.edit', compact('taskboard', 'users'));
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

        $taskboard = Taskboard::findOrFail($id);
        $taskboard->name = $request->name;
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
