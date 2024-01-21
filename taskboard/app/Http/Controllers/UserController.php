<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\UserServiceInterface;
use App\Services\TaskboardServiceInterface;

class UserController extends Controller
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
     *
     * ユーザー一覧を表示します。
     */
    public function index(Request $request)
    {
        $search = "";
        // 検索値
        if(isset($request->search))
        {
            $search = $request->search;
        }
        
        $users = $this->userService->getUserList($search);
        
        $userList = array();
        foreach($users as $user) {
            $userList[] = [
                $user[0],                 // ユーザーID
                $user[1],                 // 名前
                $user[2],                 // メードアドレス
                getUserType($user[4]),    // ユーザータイプ
                getUserStatus($user[5])   // ユーザー状態
            ];
        }
        
        $data = [
            'datas' => $userList,
            'search' => $search
        ];
        return view('users.index', $data);
    }

    /**
     * ユーザー新規作成画面を表示します。
     */
    public function create()
    {
        // ユーザータイプを取得
        $userTypes =  getUserTypeCodeArray();
        
        // タスクボードの一覧
        $taskboardList = $this->taskboardService->getTaskboardList('');

        // 表示用に整理
        $taskboards = array();
        foreach($taskboardList as $taskboard)
        {
            $board = array();
            
            $board[] = $taskboard[0];
            $board[] = $taskboard[1];

            $taskboards[] = $board;
        }

        $data = [ 
            'userTypes' => $userTypes,
            'taskboards' => $taskboards
        ]; 

        return view('users.create', $data);
    }

    /**
     * 新しいユーザーを保存します。
     */
    public function store(Request $request)
    {
        // 入力値のチェック
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'userType' => 'required|numeric',
            'taskboardUsers' => 'required|array'
        ]);
        
        // 登録処理
        $user = $this->userService->createUser([
            'name'  => $request->name,
            'email' => $request->email,
            'user_type' => $request->userType
            ]);

        // 利用するタスクボードを登録
        $taskboardUsers = $request->taskboardUsers;
        $Taskboard = $this->taskboardService->createOrUpdateuserTaskboards($user['userId'], $taskboardUsers);
        
        // 完了ページのメッセージ表示 
        if(!empty($user) && !empty($Taskboard)) {
            // 成功
            $message = '登録完了しました。';
        } else {
            // 失敗
            $message = '登録失敗しました。';
        }
        
        // 登録完了ページの表示
        $data = [
            'message' => $message,
            'link' => 'users.index',
            'button' => 'ユーザー一覧ページ'
        ];
        return view('base.complete', $data);

    }

    /**
     * ユーザー更新画面を表示します。
     */
    public function edit($id)
    {
        // ユーザータイプを取得
        $userTypes =  getUserTypeCodeArray();
        
        // タスクボードの一覧
        $taskboardList = $this->taskboardService->getTaskboardList('');

        // 表示用に整理
        $taskboards = array();
        foreach($taskboardList as $taskboard)
        {
            $board = array();
            
            $board[] = $taskboard[0];
            $board[] = $taskboard[1];

            $taskboards[] = $board;
        }

        $data = [
            'userId' => $id,
            'userTypes' => $userTypes,
            'taskboards' => $taskboards
        ]; 
        
        // ユーザー詳細取得
        $user = $this->userService->getUser($id);
        
        //  表示用に整理
        $data['name']  = $user['name'];
        $data['email'] = $user['email'];
        $data['Type']  = $user['userType'];
        
        // 利用タスクボード
        $useTaskboards = array();
        
        // タスクボードの利用状況取得
        $taskboardUsers = $this->taskboardService->getUserTaskboards($id);
        foreach($taskboardUsers as $key => $value) {
            $useTaskboards[] = $value[0];
        }
        
        $data['taskboardUsers'] = $useTaskboards;
       // dd($data);
        return view('users.edit', $data);
    }

    /**
     * ユーザー情報の更新を処理します。
     */
    public function update(Request $request, $id)
    {
        // 入力値のチェック
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'. $id . ',userId',
            'userType' => 'required|numeric',
            'taskboardUsers' => 'required|array'
        ]);
        
        // 更新処理
        $user = $this->userService->updateUser([
            'id' => $id,
            'name'  => $request->name,
            'email' => $request->email,
            'user_type' => $request->userType
            ]);
            
        // 利用するタスクボードを更新
        $taskboardUsers = $request->taskboardUsers;
        $taskboard = $this->taskboardService->createOrUpdateuserTaskboards($id, $taskboardUsers);
        
        // 完了ページのメッセージ表示 
        if(!empty($user) && !empty($taskboard)) {
            // 成功
            $message = '更新完了しました。';
        } else {
            // 失敗
            $message = '更新失敗しました。';
        }
        
        // 更新完了ページの表示
        $data = [
            'message' => $message,
            'link' => 'users.index',
            'button' => 'ユーザー一覧ページ'
        ];
        return view('base.complete', $data);
    }

    /**
     * 単数ユーザーの削除。
     */
    public function destroy($id)
    {
       // ユーザー削除処理
       return $this->userDelete([$id]);
    }
    
    /**
     * 複数ユーザーの削除
     */
    public function deletes(Request $request)
    {
       // 削除するユーザー
       $userList = $request->alls;
        
       // ユーザー削除処理
       return $this->userDelete($userList);
    }
    
    /**
     * ユーザー削除処理
     */
    public function userDelete(array $ids)
    {
       // 削除処理
        $flag = $this->userService->deleteUSer($ids);
        
        // 完了ページのメッセージ表示 
        if($flag) {
            // 成功
            $message = '削除完了しました。';
        } else {
            // 失敗
            $message = '削除失敗しました。';
        }

         // 削除完了ページの表示
        $data = [
            'message' => $message,
            'link' => 'users.index',
            'button' => 'ユーザー一覧ページ'
        ];
        return view('base.complete', $data); 
    }
}
