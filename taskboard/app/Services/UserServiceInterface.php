<?php
/*
* File Name: UserServiceInterface.php
* @takuya goto
*/

namespace App\Services;

interface UserServiceInterface {        
        public function getUserList($search);                     // ユーザー一覧情報を取得する
        public function createUser(array $data);                  // ユーザーの新規作成
        public function getUser($id);                             // ユーザー情報を取得する
        public function getLoginUser();                           // ログインしているユーザー情報を取得する
        public function updateUser(array $data);                  // ユーザー情報を更新する
        public function deleteUser(array $ids);                   // ユーザー情報を削除する
        public function PasswordReset($id);                       // パスワードをリセットする
        public function makePassword();                           // パスワードを生成する
        public function changePassword($password);                // パスワードを変更する
        public function sendPassword($user, $password);           // パスワードを送信する
        public function sendRegisterMail($user, $password);       // 登録完了メールを送信する
        public function sendUpdateMail($user);                    // 更新完了メールを送信する
        public function sendDeleteMail($user);                    // 削除完了メールを送信する
        public function sendMail($user, $type);                   // メール送信
        public function judgeUserAdmin();                         // ログインしているユーザーが管理者かどうかの判定
}