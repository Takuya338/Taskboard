<?php
/*
* File Name: UserRepository.php
* @takuya goto
*/

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    
    /*
    * ユーザー一覧情報を取得する
    * @param String $search 
    * @return array
    */
    public function searchUser($search) {
        $users = User::where('name', 'like', "%{$search}%")
            ->where('user_status', '!=', -1)
            ->orWhere('email', 'like', "%{$search}%")
            ->where('user_status', '!=', config('code.user.status.delete'))
            ->orderBy('id', 'asc')
            ->get();
        return $users->toArray();
    }

    /* 
    * ユーザーの新規作成
    * @param array $data
    * @return array
    */
    public function createUser(array $data) {
        try {
                $user = new User();
                $user->name = $data['name'];
                $user->email = $data['email'];
                if (isset($data['password'])) {
                    $user->password = $this->hash($data['password']);
                }
                $user->user_type = $data['user_type'];
                $user->user_status = config('code.user.status.first');
                $user->create_id = $this->getLoguinUserId();
                $user->update_id = $this->getLoguinUserId();
                $user->save();
                return $user->toArray();
        } catch (Exception $e) {
                // ユーザー作成に失敗した場合は空配列を返す
                return [];
        }
    }

    /*
    * ユーザー情報を取得する
    * @param int $id
    * @return array
    */
    public function getUserById($id) {
        $user = User::find($id);
        return $user->toArray();
    }

    /*
    * ユーザー情報を更新する
    * @param int $id
    * @param array $data
    * @return array
    */
    public function updateUser($id, array $data) {
        try {
                $user = User::find($id);
                if(isset($data['name'])) {
                    $user->name = $data['name'];
                }
                if(isset($data['email'])) {
                    $user->name = $data['email'];
                }
                if (isset($data['password'])) {
                    $user->password = $this->hash($data['password']);
                }
                if(isset($data['user_type'])) {
                    $user->user_type = $data['user_type'];
                }
                if(isset($data['user_status'])) {
                    $user->user_status = $data['user_status'];
                }
                $user->update_id = $this->getLoguinUserId();
                $user->save();
                return $user->toArray();
        } catch (Exception $e) {
                // ユーザー情報の更新に失敗した場合は空配列を返す
                return [];
        }
    }

    /*
    * ユーザー情報を削除する
    * @param int $id
    * @return array
    */
    public function deleteUser($id) {
        try {
                $user = User::find($id);
                // ユーザーのメールアドレスを待避するために取得
                $email = $user->email;
                $user->update($id, ['user_status' => config('code.user.status.delete'), 'email' => 'delete', 'updator_id' => $this->getLoguinUserId()]);
                $deletedUser = $user->toArray();
                // ユーザーのメールアドレスを待避
                $deletedUser['email'] = $email;
                return $deletedUser;
        } catch (Exception $e) {
                // ユーザー情報の削除に失敗した場合は空配列を返す
                return [];
        }

    }

    /*
    * ユーザーIDをメールアドレスから取得する
    * @param String $email
    * @return int ユーザーID
    */
    public function getUserByEmail($email) {

        $user = User::where('email', $email)->first();
        return $user->user_id;
    }

    /*
    * パスワードのハッシュ化
    * @param String $password
    * @return String　ハッシュ化されたパスワード
    */ 
    public function hashWord($password) {
        return bcrypt($password);
    }

    /*
    * ログインしているユーザーIDを取得する
    * @return int ログインしているユーザーID
    */
    public function getLoguinUserId() {
        return Auth::id();
    }

    /*
    *　ユーザーのパスワードを変更する
    * @param int $id
    * @param String $password
    * @return array
    */
    public function changePassword($password, $id = null) {
        try {
            // ユーザー状態
            $status = 9;
            
            // ログインしているユーザーID
            $loginUserId = $this->getLoguinUserId();
            
            // ユーザーIDが指定されていない場合はログインユーザーのIDを取得
            if($id == null) {
                $id = $loginUserId;
                $status = 0;
            }
            $user = User::find($id);
            $user->password = $this->hash($password);
            $user->update_id = $loginUserId;
            $user->user_status = $status;
            $user->save();
            return $user->toArray();
        } catch (Exception $e) {
            // ユーザー情報の更新に失敗した場合は空配列を返す
            return [];
        }
    }

}