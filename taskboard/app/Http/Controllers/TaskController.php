<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskboardServiceInterface;
use App\Services\UserServiceInterface;

class TaskController extends Controller
{
    
    private $taskboardService;
    
    /*
    * コンストラクタ
    */
    public function __construct(TaskboardServiceInterface $TaskboardService, UserServiceInterface $UserService)
    {
        $this->taskboardService = $TaskboardService;
        $this->userService = $UserService;
    }

    /*
    * タスク作成ページ
    */
    public function create($id)
    {
        // ユーザー一覧取得
        $users = $this->taskboardService->getTaskboardUsers($id);
        
        $data = ['taskboardId' => $id,
                 'users'=>$users
        ];

        return view('tasks.create', $data);
    }

    /*
    * タスク作成処理
    */
    public function store(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
            'user' => 'required',
        ]);

        $task = [ 'content' => $request->content,
                  'userId'  => $request->user,
        ];
    
        // タスク作成処理
        $this->taskboardService->createTaskboardTask($id, $task);

        $data = [
            'message' => 'タスク追加完了しました。',
            'link' => 'board',
            'id' => $id,
            'button' => 'タスクボードページ'
        ];

        return view('base.complete', $data);
    }


    /*
    * タスク状態変更
    */
    public function updateStatus(Request $request, $id, $taskId)
    {
        // タスクボードページへ遷移
        return redirect()->route('board', ['id' => $id]);
    }

}