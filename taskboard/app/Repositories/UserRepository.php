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
        $users = User::where('name', 'like', "%" . $search ."%")
            ->where('userStatus', '!=', -1)
            ->orWhere('email', 'like', "%" . $search . "%")
            ->where('userStatus', '!=', config('code.user.status.delete'))
            ->orderBy('userId', 'asc')
            ->get()
            ->toArray();
        
        
        $list = array();
        foreach($users as $user)
        {
            $list[] = array_values((array)$user);
        }
        return $list;
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
                    $user->password = $this->hashWord($data['password']);
                }
                $user->userType = $data['user_type'];
                $user->userStatus = config('code.user.status.first');
                $user->creatorId = $this->getLoginUserId();
                $user->updaterId = $this->getLoginUserId();
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
                    $user->email = $data['email'];
                }
                if (isset($data['password'])) {
                    $user->password = $this->hashWord($data['password']);
                }
                if(isset($data['userType'])) {
                    $user->userType = $data['user_type'];
                }
                if(isset($data['userStatus'])) {
                    $user->userStatus = $data['user_status'];
                }
                $user->updaterId = $this->getLoginUserId();
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
                $user->update(['userStatus' => config('code.user.status.delete'), 'email' => $id . '@delete.com', 'updatorId' => $this->getLoginUserId()]);
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
    public function getLoginUserId() {
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
            $loginUserId = $this->getLoginUserId();
            
            // ユーザーIDが指定されていない場合はログインユーザーのIDを取得
            if($id == null) {
                $id = $loginUserId;
                $status = 0;
            }
            $user = User::find($id);
            $user->password = $this->hashWord($password);
            $user->updaterId = $loginUserId;
            $user->userStatus = $status;
            $user->save();
            return $user->toArray();
        } catch (Exception $e) {
            // ユーザー情報の更新に失敗した場合は空配列を返す
            return [];
        }
    }
    
    /*
    * ログインしているユーザーのタイプを取得
    * @return int 
    */
    public function getLoginUserType() {
       $user = $this->getLoginUser();
       return $user['userType'];
    }
    
    /*
    * ログインしているユーザー情報を取得
    * @return array
    */
    public function getLoginUser() {
        $id = Auth::id();
        $user = User::find($id);
        return $user->toArray();
    }


}