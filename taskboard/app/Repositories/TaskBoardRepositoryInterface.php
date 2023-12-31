<?php
/*
* File Name: TaskBoardRepositoryInterface.php
* @takuya goto
*/

namespace App\Repositories;

interface TaskBoardRepositoryInterface
{  
    public function search($search);                                         // タスクボード一覧情報を取得する
    public function create(array $data);                                     // タスクボードの新規作成
    public function detail($id);                                             // タスクボードを取得する
    public function update($id, array $data);                                // タスクボードを更新する
    public function delete($id);                                             // タスクボードを削除する
    public function getUsersByTaskboardId($id);                              // タスクボードの利用者一覧を取得する
    public function createOrUpdateTaskboardUsers($id, array $data);          // タスクボードの利用者を新規作成または更新する
    public function deleteTaskboardUsers($id);                               // タスクボードの利用者を削除する
    public function createTask($id, array $data);                            // タスクを新規作成する
    public function updateTask($id, array $data);                            // タスクを更新する
    public function getTaskByTaskboardId($id);                               // タスクボードのタスク一覧を取得する
}