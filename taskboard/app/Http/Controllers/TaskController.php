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
        // ログインしているユーザーがタスクボードの利用者でない場合または管理者でない場合
        if(!$this->taskboardService->judgeLoginUserTaskboard($id) && !$this->userService->judgeUserAdmin()) {
            return $this->hidden();
        }
        
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
        // ログインしているユーザーがタスクボードの利用者でない場合または管理者でない場合
        if(!$this->taskboardService->judgeLoginUserTaskboard($id) && !$this->userService->judgeUserAdmin()) {
            return $this->hidden();
        }
        
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
        
        // 追加完了ページの表示
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
    public function updateStatus($taskboardId, $userId, $taskId, $taskStatus)
    {
        // ログインしているユーザーがタスクボードの利用者でない場合または管理者でない場合
        if(!$this->taskboardService->judgeLoginUserTaskboard($taskboardId) && !$this->userService->judgeUserAdmin()) {
            return $this->hidden();
        }
        
        // タスク状態変更
        $task = $this->taskboardService->updateTaskboardTask($taskId, [
            'userId' => $userId,
            'taskStatus' => $taskStatus
        ]);
        
        
        // タスクボードページへ遷移
        return redirect()->route('board', ['id' => $taskboardId]);
    }
    
    /*
    * 禁止ページの表示
    */
    public function hidden()
    {
        $data = [
            'message' => 'このページは許可されていないページです。',
            'link' => 'taskboards.index',
            'button' => 'タスクボードページ'
        ];

        return view('base.complete', $data);
    }

}