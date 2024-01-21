<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskboardServiceInterface;
use App\Services\UserServiceInterface;

class TaskBoardController extends Controller
{
    
    private $taskboardService;
    private $userService;
    
    /*
    * コンストラクタ
    */
    public function __construct(TaskboardServiceInterface $TaskboardService, UserServiceInterface $UserService)
    {
        $this->taskboardService = $TaskboardService;
        $this->userService = $UserService;
    }
    
    /*
    * タスクボード一覧を表示します。
    */
    public function index(Request $request)
    {
        
        $search = "";
        
        // 検索値
        if(isset($request->search))
        {
            $search = $request->search;
        }
        // タスクボードの一覧取得        
        $taskboards = $this->taskboardService->getTaskboardList($search);

        return view('taskboards.index', compact('taskboards'));
    }

    /**
     * タスクボード新規作成画面を表示します。
     */
    public function create()
    {
        $users = $this->userService->getUserList('');
        return view('taskboards.create', compact('users'));
    }

    /**
     * 新しいタスクボードを保存します。
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'list' => 'required|array',
        ]);
        
        // タスクボードの作成
        $taskboard = $this->taskboardService->createTaskboard([$request->name]);

        // タスクボードのID
        $taskboardId = $taskboard['taskboardId'];
        
        // タスクボードにユーザーを割り当てる
        $users = $request->list;


        // タスクボードの利用者作成
        $taskboardUsers = $this->taskboardService->createOrUpdateTaskboardUsers($taskboardId, $users);
       
        // 登録完了ページの表示
        $data = [
            'message' => '登録完了しました。',
            'link' => 'taskboards.index',
            'button' => 'タスクボード一覧ページ'
        ];
        
        return view('base.complete', $data);
    }

    /**
     * タスクボードの編集画面を表示します。
     */
    public function edit($id)
    {
        // タスクボード情報を取得
        $board = $this->taskboardService->getTaskboard($id);
        $taskboard = $board[0];

        // タスクボードの利用者一覧を取得
        $userArray = $this->taskboardService->getTaskboardUsers($id);
        $userList = array();
        foreach($userArray as $user){
            $userList[] = $user[0];
        }

        // 全ユーザー一覧を取得
        $users = $this->userService->getUserList('');
        return view('taskboards.edit', compact('taskboard', 'users', 'userList'));
    }

    /**
     * タスクボードの更新を処理します。
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'list' => 'required|array',
        ]);
        
        // タスクボードの更新
        $taskboard = $this->taskboardService->updateTaskboard([$id, $request->name]);
        
        // タスクボードにユーザーを割り当てる
        $users = $request->list;

        // タスクボードの利用者作成
        $taskboardUsers = $this->taskboardService->createOrUpdateTaskboardUsers($id, $users);

        $data = [
            'message' => '更新完了しました。',
            'link' => 'board',
            'id' => $id,
            'button' => 'タスクボードページ'
        ];

        return view('base.complete', $data);
    }

    /**
     * タスクボードを削除します。
     */
    public function destroy($id)
    {
        // タスクボードの削除;
        $taskboard = $this->taskboardService->deleteTaskboard([$id]);

        $data = [
            'message' => '削除完了しました。',
            'link' => 'taskboards.index',
            'button' => 'タスクボードページ'
        ];

        return view('base.complete', $data);
    }

    /**
     * タスクボードページの表示
     */
    public function show($id)
    {    
        // タスクボード情報を取得
        $board = $this->taskboardService->getTaskboard($id);
        $taskboard = $board[0];

        // タスクボードの利用者一覧を取得
        $userArray = $this->taskboardService->getTaskboardUsers($id);
        $userList = array();
        foreach($userArray as $user){
            $userList[] = $user[1];
        }
        $userName = implode(",", $userList);

        // タスクを取得
        $tasks = $this->taskboardService->getTaskboardTasks($id);

        return view('taskboards.taskboard', compact('taskboard', 'userArray', 'userName', 'tasks'));
    } 
}
