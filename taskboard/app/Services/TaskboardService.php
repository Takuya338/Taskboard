<?php
/*
* File Name: TaskboardService.php
* @takuya goto
*/
class TaskboardService implements TaskboardServiceInterface {
    
    
    
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
        return $this->taskboardRepository->createTaskboard(array $data);
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
        return $this->taskboardRepository->updateTaskboard(array $data);
    }

    /*
    * タスクボード情報を削除する
    * @param array $ids
    * @return array
    */
    public function deleteTaskboard(array $ids) {
        return $this->taskboardRepository->deleteTaskboard(array $ids);
    }

    /*
    * タスクボードに紐づくユーザー情報を取得する
    * @param int $id
    * @return array
    */
    

}