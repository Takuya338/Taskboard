<?php
/*
* File Name: TaskboardRepository.php
* @takuya goto
*/

namespace App\Repositories;

use App\Models\Taskboard;
use App\Models\TaskboardUser;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Repositories\TaskBoardRepositoryInterface;

class TaskBoardRepository implements TaskBoardRepositoryInterface {
    
    /*
    * タスクボード一覧情報を取得する
    * @param String $search
    * @return array
    */
    public function getTaskboardList($search) {
        if (Auth::user()->userType == config('code.user.type.admin')) {
            // ログインしているユーザーが管理者の場合
            $taskboards = DB::table('taskboard')
                ->join('users', 'taskboard.updaterId', '=', 'users.userId')
                ->select('taskboard.taskboardId', 'taskboard.taskboardName', 'users.name', 'taskboard.updated_at')
                ->where('taskboardName', 'like', '%' . $search . '%')
                ->orderBy('taskboard.updated_at', 'desc')
                ->get()
                ->toArray();
        } else {
            // ログインしているユーザーが管理者の以外場合
            $taskboards = DB::table('taskboard')
                ->join('users', 'taskboard.updaterId', '=', 'users.userId')
                ->join('taskboard_user', 'taskboard_user.taskboardId', '=', 'taskboard.taskboardId')
                ->select('taskboard.taskboardId', 'taskboard.taskboardName', 'users.name', 'taskboard.updated_at')
                ->where('taskboardName', 'like', '%' . $search . '%')
                ->where('taskboard_user.userId', '=', $this->getLoginUserId())
                ->orderBy('taskboard.updated_at', 'desc')
                ->get()
                ->toArray();
        }
        
        return changeEloquentToArray($taskboards);
    }

    /*
    * タスクボードの新規作成
    * @param array $data
    * @return array
    */
    public function createTaskboard($data) {
        $taskboard = new Taskboard();
        $taskboard->taskboardName = $data[0];
        $taskboard->creatorId = $this->getLoginUserId();
        $taskboard->updaterId = $this->getLoginUserId();
        $taskboard->save();
        return $taskboard->toArray();
    }

    /*
    * タスクボード情報を取得する
    * @param int $id
    * @return array
    */
    public function getTaskboard($id) {
        $results = DB::table('taskboard as tb')
            ->leftJoin('tasks as t', 'tb.taskboardId', '=', 't.taskboardId')
            ->where('tb.taskboardId', $id)
            ->select('tb.taskboardId', 'tb.taskboardName') 
            ->get()
            ->toArray();
        return changeEloquentToArray($results);
    }

    /*
    * タスクボード情報を更新する
    * @param int $id
    * @param array $data
    * @return array
    */
    public function updateTaskboard($data) {
        $taskboard = Taskboard::find($data[0]);
        $taskboard->taskboardName = $data[1];
        $taskboard->updaterId = $this->getLoginUserId();
        $taskboard->save();
        return $taskboard->toArray();
    }

    /*
    * タスクボード情報を削除する
    * @param int $id
    * @return true
    */
    public function deleteTaskboard($ids) {
        $taskboard = Taskboard::whereIn('taskboardId', $ids);
        $taskboard->delete();
        return true;
    }

    /*
    * タスクボードの利用者一覧を取得する
    * @param int $id
    * @return array
    */
    public function getUsersByTaskboardId($id) {
        $results = DB::table('taskboard_user as tbu')
            ->leftJoin('users as u', 'tbu.userId', '=', 'u.userId')
            ->where('tbu.taskboardId', $id)
            ->select('tbu.userId', 'u.name')
            ->get()
            ->toArray();
        return changeEloquentToArray($results);
    }
 
    /*
    * ユーザーの利用タスクボード一覧を取得する
    * @param int $id
    * @return array
    */
    public function getTaskboardsByUserId($id) {
        $results = DB::table('taskboard_user as tbu')
            ->leftJoin('users as u', 'tbu.userId', '=', 'u.userId')
            ->where('tbu.userId', $id)
            ->select('tbu.taskboardId')
            ->get()
            ->toArray();
        return changeEloquentToArray($results);
    } 
    

    /*
    * タスクボードの利用者を新規作成または更新する
    * @param int $id
    * @param array $data
    * @return bool
    */
    public function createOrUpdateTaskboardUsers($id, array $data) {
        // ログインしているユーザーIDを取得する
        $loginId = $this->getLoginUserId();

        foreach($data as $userId)
        {
            // 既にデータベースに登録されているかどうかの判定
            $count = TaskboardUser::where('userId', $userId)
               ->where('taskboardId', $id)
               ->count();
                       
            if($count == 0) {
                // 登録
                $taskboardUser = new TaskboardUser();
                $taskboardUser->taskboardId = $id;
                $taskboardUser->userId = $userId;
                $taskboardUser->creatorId = $loginId;
                $taskboardUser->updaterId = $loginId;
                $taskboardUser->save();
            } else {
                // 更新
                $taskboardUser = TaskboardUser::where('taskboardId', $id)
                               ->where('userId', $userId)
                               ->update(['updaterId' => $loginId]);
            }
        }

        return true;
    } 
    
    /*
    * タスクボードの利用者を新規作成または更新する
    * @param int $id
    * @param array $data
    * @return array
    */
    public function createOrUpdateUserTaskboards($id, array $data) {
        // ログインしているユーザーIDを取得する
        $loginId = $this->getLoginUserId();

        $taskboardUsers = array();

        foreach($data as $taskboardId)
        {
            // 既にデータベースに登録されているかどうかの判定
            $count = TaskboardUser::where('taskboardId', $taskboardId)
               ->where('userId', $id)
               ->count();
                       
            if($count == 0) {
                // 登録
                $taskboardUser = new TaskboardUser();
                $taskboardUser->userId = $id;
                $taskboardUser->taskboardId = $taskboardId;
                $taskboardUser->creatorId = $loginId;
                $taskboardUser->updaterId = $loginId;
                $taskboardUser->save();
            } else {
                // 更新
                $taskboardUser = TaskboardUser::where('userId' ,$id)->where('taskboardId', $taskboardId)->first();
                $taskboardUser->userId = $id;
                $taskboardUser->taskboardId = $taskboardId;
                $taskboardUser->updaterId = $loginId;
                $taskboardUser->save();

            }
            
            // 登録結果を配列に格納
            $taskboardUsers[] = $taskboardUser->toArray();
        }

        return changeEloquentToArray($taskboardUser);
    } 
    
    /*
    * タスクボードの利用者を削除する
    * @param int $id
    * @return true
    */
    public function deleteTaskboardUsers($id, array $data = null) {
        if($data != null) {
            return TaskboardUser::where('taskboardId', $id)->whereIn('userId', $data)->delete();
        } else {
            return TaskboardUser::where('taskboardId', $id)->delete(); 
        }
    }
    
    /*
    * ユーザーの利用タスクボードを削除する
    * @param int $id
    * @return true
    */
    public function deleteUserTaskboards($id, array $data = null) {
        if($data != null) {
            return TaskboardUser::where('userId', $id)->whereIn('taskboardId', $data)->delete();
        } else {
            return TaskboardUser::where('userId', $id)->delete(); 
        }
    }

    /*
    * タスクを新規作成する
    * @param $id
    * @param array $data
    * @return array
    */
    public function createTask($id, array $data) {
        $task = new Task();
        $loginId = $this->getLoginUserId();
        $task->taskboardId = $id;
        $task->content    = $data['content'];
        $task->taskStatus = config('code.taskboard.status.todo');
        $task->executorId = $data['userId'];
        $task->creatorId = $loginId;
        $task->updaterId = $loginId;
        $task->save();
        return $task->toArray();
    }

    /*
    * タスクを更新する
    * @param int $id
    * @param array $data
    * @return array
    */
    public function updateTask($id, array $data) {
        $task = Task::find($id);
        if(isset($data['content'])) {
            $task->content = $data['content'];
        }
        if(isset($data['taskStatus'])) {
            $task->taskStatus = $data['taskStatus'];  
        }
        if(isset($data['userId'])) {
            $task->executorId = $data['userId'];
        }
        $task->updaterId = $this->getLoginUserId();
        $task->save();
        return $task->toArray();
    }

    /*
    * タスクボードのタスク一覧を取得する
    * @param int $id
    * @return array
    */
    public function getTaskByTaskboardId($id) {
        $results = DB::table('tasks as t')
            ->leftJoin('taskboard as tb', 't.taskboardId', '=', 'tb.taskboardId')
            ->leftJoin('users as u', 'u.userId', '=', 't.executorId')
            ->where('t.taskboardId', $id)
            ->select('t.taskId', 't.content', 'u.userId', 'u.name', 't.updated_at', 't.taskStatus')
            ->get()
            ->toArray();
        return changeEloquentToArray($results);
    }

    /*
    * ログインしているユーザーのIDを取得する
    * @return int
    */ 
    public function getLoginUserId() {
        return Auth::id();
    }
    
    /*
    * タスクボードの利用者の中にがログインしているユーザーが含まれているかどうかを判定
    * @param int $taskboardId
    * @return bool
    */ 
    public function getUserTaskboard($taskboardId) {
        // ユーザーIDを取得
        $id = $this->getLoginUserId();
        
        // タスクボードにユーザーが紐づけられているかどうかを調べる
        return  DB::table('taskboard_user')
        ->where('taskboardId', $taskboardId)
        ->where('userId', $id)
        ->count();
    }

}