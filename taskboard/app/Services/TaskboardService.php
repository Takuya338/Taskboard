<?php
/*
* File Name: TaskboardService.php
* @takuya goto
*/

namespace App\Services;

use App\Services\TaskboardServiceInterface;
use App\Repositories\TaskBoardRepository;
use App\Repositories\TaskBoardRepositoryInterface;

class TaskboardService implements TaskboardServiceInterface {
    
    private $taskboardRepository;
    
    /*
    * コンストラクタ
    */
    public function __construct(TaskBoardRepositoryInterface $TaskBoardRepository)
    {
        $this->taskboardRepository = $TaskBoardRepository;
    }
    
    /*
    * タスクボード一覧情報を取得する
    * @param String $search
    * @return array
    */
    public function getTaskboardList($search) {
        return $this->taskboardRepository->getTaskboardList($search);
    }

    /*
    * タスクボードの新規作成
    * @param array $data
    * @return array
    */
    public function createTaskboard(array $data) {
        return $this->taskboardRepository->createTaskboard($data);
    }

    /*
    * タスクボード情報を取得する
    * @param int $id
    * @return array
    */
    public function getTaskboard($id) {
        return $this->taskboardRepository->getTaskboard($id);
    }

    /*
    * タスクボード情報を更新する
    * @param array $data
    * @return array
    */
    public function updateTaskboard(array $data) {
        return $this->taskboardRepository->updateTaskboard($data);
    }

    /*
    * タスクボード情報を削除する
    * @param array $ids
    * @return array
    */
    public function deleteTaskboard(array $ids) {
        return $this->taskboardRepository->deleteTaskboard($ids);
    }

    /*
    * タスクボードに紐づくユーザー情報を取得する
    * @param int $id
    * @return array
    */
    public function getTaskboardUsers($id) {}                             // タスクボードに紐づくユーザー情報を取得する
    public function createOrUpdateTaskboardUsers($id, array $data) {}     // タスクボードに紐づくユーザー情報を作成または更新する
    public function deleteTaskboardUsers($id, array $ids) {}              // タスクボードに紐づくユーザー情報を削除する
    public function getTaskboardTasks($id) {}                             // タスクボードに紐づくタスク情報を取得する
    public function createTaskboardTask($id, array $data) {}              // タスクボードに紐づくタスクの新規作成
    public function updateTaskboardTask($id, array $data) {}              // タスクボードに紐づくタスク情報を更新する
    public function deleteTaskboardTask($id, array $ids) {} 
    

}