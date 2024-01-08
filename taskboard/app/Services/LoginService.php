<?php
/*
* File Name: LoginService.php
* @takuya goto
*/

namespace App\Services;

use App\Services\LoginServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginService implements LoginServiceInterface {
    
    /* 
    * ログイン処理
    * @param String $email
    * @param String $password
    * @return boolean
    */
    public function login($email, $password) {
        try {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                // 認証に成功した
                return true;
            } else {
                // 認証に失敗した
                return false;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /* 
    * ログアウト処理
    * @return boolean
    */
    public function logout() {
        try {
            Auth::logout();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}