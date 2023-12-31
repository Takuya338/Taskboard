<?php
/*
* File Name: LoginServiceInterface.php
* @takuya goto
*/
Interface LoginServiceInterface {
    public function login($email, $password);      // ログイン処理
    public function logout();                      // ログアウト処理
}    