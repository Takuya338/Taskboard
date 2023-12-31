<?php
/*
* File Name: TaskboardRepository.php
* @takuya goto
*/

namespace App\Repositories;

use App\Models\Taskboard;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TaskboardRepository implements TaskboardRepositoryInterface {
    
     /*
    * タスクボード一覧情報を取得する
    * @param String $search
    * @return array
    */
    public function search($sarch) {
        
        if (Auth::user()->user_type == 1) {
            // ログインしているユーザーが管理者の場合
            $taskboards = DB::table('taskboards')
                ->join('users', 'taskboards.update_id', '=', 'users.id')
                ->select('taskboards.taskboard_name', 'users.users.name', 'taskboards.update_at')
                ->where('taskboard_name', 'like', "%{$search}%")
                ->orderBy('taskboards.update_at', 'desc')
                ->get()
                ->toArray();
        } else {
            // ログインしているユーザーが管理者の以外場合
            $taskboards = DB::table('taskboards')
                ->join('users', 'taskboards.update_id', '=', 'users.id')
                ->select('taskboards.taskboard_name', 'users.users.name', 'taskboards.update_at')
                ->where('taskboard_name', 'like', "%{$search}%")
                ->where('taskboards.update_id', '=', $this->getLoguinUserId())
                ->orderBy('taskboards.update_at', 'desc')
                ->get()
                ->toArray();
        }

        return $taskboards;
    }

    /*
    * タスクボードの新規作成
    * @param array $data
    * @return array
    */
    public function create(array $data) {
        $taskboard = new Taskboard();
        $taskboard->taskboard_name = $data['taskboard_name'];
        $taskboard->creator_id = $this->getLoguinUserId();
        $taskboard->updater_id = $this->getLoguinUserId();
        $taskboard->save();
        return $taskboard->toArray();
    }

    /*
    * タスクボード情報を取得する
    * @param int $id
    * @return array
    */
    public function detail($id) {
        $results = DB::table('taskboards as tb')
            ->leftJoin('tasks as t', 'tb.taskboard_id', '=', 't.taskboard_id')
            ->where('tb.taskboard_id', $id)
            ->select('tb.*', 't.*') // 必要に応じて選択するカラムを指定
            ->get()
            ->toArray();
        return $results;
    }

    /*
    * タスクボード情報を更新する
    * @param int $id
    * @param array $data
    * @return array
    */
    public function update($id, array $data) {
        $taskboard = Taskboard::find($id);
        $taskboard->taskboard_name = $data['taskboard_name'];
        $taskboard->updater_id = $this->getLoguinUserId();
        $taskboard->save();
        return $taskboard->toArray();
    }

    /*
    * タスクボード情報を削除する
    * @param int $id
    * @return true
    */
    public function delete($id) {
        $taskboard = Taskboard::find($id);
        $taskboard->delete();
        return true;
    }

    /*
    * タスクボードの利用者一覧を取得する
    * @param int $id
    * @return array
    */
    public function getUsersByTaskboardId($id) {
        $results = DB::table('taskboard_users as tbu')
            ->leftJoin('users as u', 'tbu.user_id', '=', 'u.id')
            ->where('tbu.taskboard_id', $id)
            ->select('tbu.*', 'u.*') // 必要に応じて選択するカラムを指定
            ->get()
            ->toArray();
        return $results;
    }

    /*
    * タスクボードの利用者を新規作成または更新する
    * @param int $id
    * @param array $data
    * @return array
    */
    public function createOrUpdateTaskboardUsers($id, array $data) {
        // ログインしているユーザーIDを取得する
        $loginId = $this->getLoguinUserId();

        $taskboardUsers = array();

        foreach($userId as $data)
        {
            $taskboardUser = TaskboardUsers::updateOrCreate(
                ['taskboard_id' => $id, 'user_id' => $userId],
                ['updater_id' => $loginId()]
            );

            $taskboardUsers[] = $taskboardUser->toArray();
        }

        return $taskboardUsers;
    } 
    
    /*
    * タスクボードの利用者を削除する
    * @param int $id
    * @return true
    */
    public function deleteTaskboardUsers($id) {
        TaskboardUsers::where('taskboard_id', $id)->delete();
        return true;
    }

    /*
    * タスクを新規作成する
    * @param array $data
    * @return array
    */
    public function createTask(array $data) {
        $task = new Task();
        $loginId = $this->getLoguinUserId();
        $task->content   = $data['content'];
        $task->status    = $data['status'];
        $task->user_id   = $data['user_id'];
        $task->creator_id = $loginId();
        $task->updater_id = $loginId();
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
        $task->taskboard_id = $id;
        $task->content   = $data['content'];
        $task->status    = $data['status'];
        $task->user_id   = $data['user_id'];
        $task->updater_id = $this->getLoguinUserId();
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
            ->leftJoin('taskboards as tb', 't.taskboard_id', '=', 'tb.taskboard_id')
            ->where('t.taskboard_id', $id)
            ->select('t.*', 'tb.*') // 必要に応じて選択するカラムを指定
            ->get()
            ->toArray();
        return $results;
    }

    /*
    * ログインしているユーザーのIDを取得する
    * @return int
    */ 
    public function getLoguinUserId() {
        return Auth::user()->id;
    }

}