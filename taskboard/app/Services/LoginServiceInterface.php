<?php
/*
* File Name: LoginServiceInterface.php
* @takuya goto
*/

namespace App\Services;

interface LoginServiceInterface {
    public function login($email, $password);      // ログイン処理
    public function logout();                      // ログアウト処理
}    