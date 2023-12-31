<?php
/*
* File Name: UserRepository.php
* @takuya goto
*/

namespace App\Repositories;

interface UserRepositoryInterface
{  
    public function searchUser($search);                         // ユーザー一覧情報を取得する
    public function createUser(array $data);                     // ユーザーの新規作成
    public function getUserById($id);                             // ユーザー情報を取得する
    public function updateUser($id, array $data);                // ユーザー情報を更新する
    public function deleteUser($id);                             // ユーザー情報を削除する
    public function getUserByEmail($email);                  // ユーザーIDをメールアドレスから取得する
    public function hashWord($password);                         // パスワードのハッシュ化
    public function getLoguinUserId();                       // ログインしているユーザーIDを取得する
    public function changePassword($password, $id = null);   // ユーザーのパスワードを変更する
}
