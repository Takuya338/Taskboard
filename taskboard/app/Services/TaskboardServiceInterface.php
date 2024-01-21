<?php
/*
* File Name: TaskboardServiceInterface.php
* @takuya goto
*/

namespace App\Services;

interface TaskboardServiceInterface {
    public function getTaskboardList($search);                          // タスクボード一覧情報を取得する
    public function createTaskboard(array $data);                       // タスクボードの新規作成
    public function getTaskboard($id);                                  // タスクボード情報を取得する
    public function updateTaskboard(array $data);                       // タスクボード情報を更新する
    public function deleteTaskboard(array $ids);                        // タスクボード情報を削除する
    public function getTaskboardUsers($id);                             // タスクボードに紐づくユーザー情報を取得する
    public function getUserTaskboards($id);                             // ユーザーに紐づくタスクボード情報を取得する
    public function createOrUpdateTaskboardUsers($id, array $data);     // タスクボードに紐づくユーザー情報を作成または更新する
    public function createOrUpdateUserTaskboards($id, array $data);     // ユーザーに紐づくタスクボード情報を作成または更新する
    public function deleteTaskboardUsers($id, array $ids);              // タスクボードに紐づくユーザー情報を削除する
    public function deleteUserTaskboards($id, array $ids);              // ユーザーに紐づくタスクボード情報を削除する
    public function getTaskboardTasks($id);                             // タスクボードに紐づくタスク情報を取得する
    public function createTaskboardTask($id, array $data);              // タスクボードに紐づくタスクの新規作成
    public function updateTaskboardTask($id, array $data);              // タスクボードに紐づくタスク情報を更新する
    public function deleteTaskboardTask($id, array $ids);               // タスクボードに紐づくタスク情報を削除する
}