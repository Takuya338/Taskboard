<?php
/*
* File Name: TaskBoardRepositoryInterface.php
* @takuya goto
*/

namespace App\Repositories;

interface TaskBoardRepositoryInterface
{  
    public function getTaskboardList($search);                               // タスクボード一覧情報を取得する
    public function createTaskboard($data);                                  // タスクボードの新規作成
    public function getTaskboard($id);                                       // タスクボードを取得する
    public function updateTaskboard($data);                                  // タスクボードを更新する
    public function deleteTaskboard($ids);                                   // タスクボードを削除する
    public function getUsersByTaskboardId($id);                              // タスクボードの利用者一覧を取得する
    public function getTaskboardsByUserId($id);                              // ユーザーの利用タスクボード一覧を取得する
    public function createOrUpdateTaskboardUsers($id, array $data);          // タスクボードの利用者を新規作成または更新する
    public function deleteTaskboardUsers($id);                               // タスクボードの利用者を削除する
    public function deleteUserTaskboards($id);                               // ユーザーの利用タスクボードを削除する
    public function createTask($id, array $data);                            // タスクを新規作成する
    public function updateTask($id, array $data);                            // タスクを更新する
    public function getTaskByTaskboardId($id);                               // タスクボードのタスク一覧を取得する
    public function  getUserTaskboard($taskboardId);                         // タスクボードの利用者の中にがログインしているユーザーが含まれているかどうかの判定
}