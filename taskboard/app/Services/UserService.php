<?php
/*
* File Name: UserService.php
* @takuya goto
*/

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use App\Services\UserServiceInterface;

class UserService implements UserServiceInterface {

    private $userRepository;     // UserRepositoryInterfaceのインスタンスを格納する変数
    
    /* 
    * コンストラクタ
    * @param UserRepositoryInterface $userRepository
    * @return void
    */
    public function __construct(UserRepository $userRepository) {
        // UserRepositoryInterfaceのインスタンスを生成
        $this->userRepository = $userRepository;
    }

    /*
    * ユーザー一覧情報を取得する
    * @param String $search
    * @return array
    */
    public function getUserList($search) {
        return $this->userRepository->searchUser($search);
    }

    /*
    * ユーザーの新規作成
    * @param array $data
    * @return bool
    */
    public function createUser(array $data) {
        try {
            // パスワード作成
            $data['password'] = $this->makePassword();
    
            // ユーザー新規作成
            $user = $this->userRepository->createUser($data);

            if(empty($user)) {
                // ユーザー作成に失敗した場合
                return false;
            }
        
            // ユーザーに登録完了メールを送信
            if(!$this->sendRegisterMail($user, $data['password'])) {
                return false;
            }

            return true;

        } catch (Exception $e) {
            // ユーザー作成に失敗した場合
            return false;
        }
        
    }

    /*
    * ユーザ－の詳細を取得する
    * @param int $id
    * @return array
    */
    public function getUser($id) {
        return $this->userRepository->getUserById($id);
    }

    /*
    * ユーザーの設定を更新する
    * @param array $data
    * @return bool
    */
    public function updateUser(array $data) {
        try {
        
            // ユーザーIDを取得
            $id = $data['id'];
                
            // ユーザーIDを削除
            unset($data['id']);
                
            // ユーザー情報を更新
            $user = $this->userRepository->updateUser($id, $data);
                
            if(empty($user)) {
                // ユーザー情報の更新に失敗した場合
                return false;
            }
            
            // ユーザーに更新完了メールを送信
            return $this->sendUpdateMail($user);
            
        } catch (Exception $e) {    
            // ユーザー情報の更新に失敗した場合
            return false;
        }
    }

    /*
    * ユーザーを削除する
    * @param array $ids
    * @return bool
    */
    public function deleteUser(array $ids) {
        foreach ($ids as $id) {
            $user = $this->userRepository->deleteUser($id);
            if(empty($user)) {
                // ユーザー情報の削除に失敗した場合
                return false;
            }
            // ユーザーに削除完了メールを送信
            if(!$this->sendDeleteMail($user)) {
                return false;
            }
        }

        return true;
    }
    
	/*
    * ユーザーのパスワードをリセットする
    * @param int $id
    * @return bool
    */
    public function PasswordReset($id) {
        // パスワードを新規作成
        $password = $this->makePassword();

        // パスワードを更新
        $user = $this->userRepository->changePassword($id, $password);

        if(empty($user)) {
            // パスワードの更新に失敗した場合
            return false;
        }
        // パスワードをメールで送信
        return $this->sendPassword($user, $password);
    }
    
    /*
    * パスワードを新規作成する
    * @return string
    */
    public function makePassword() {
        // ランダムな文字列を生成
        return Str::random(8);
    }

    /*
    * ログインしているユーザーのパスワードを変更する
    * @param int $id
    * @param string $password
    * @return bool
    */
    public function changePassword($password) {

        // パスワードを更新
        $user = $this->userRepository->changePassword($password);

        if(empty($user)) {
            // パスワードの更新に失敗した場合
            return false;
        }

        // パスワードをメールで送信
        return $this->sendPassword($user, $password);
    }

    /*
    * パスワードをメールで送信する
    * @param array $user
    * @param string $password
    * @return bool
    */
    public function sendPassword($user, $password) {
        return $this->sendMail($user, 'password');
    }

    /*
    * ユーザーに登録完了メールを送信する
    * @param array $user
    * @param string $password
    * @return bool
    */
    public function sendRegisterMail($user, $password) {
        return $this->sendMail($user, 'register');
    }

    /*
    * ユーザーに更新完了メールを送信する
    * @param array $user
    * @return bool
    */
    public function sendUpdateMail($user) {
        return $this->sendMail($user, 'update');
    }

    /*
    * ユーザーに削除完了メールを送信する
    * @param array $user
    * @return bool
    */
    public function sendDeleteMail($user) {
        return $this->sendMail($user, 'delete');
    }

    /*
    * メール送信
    * @param array $user
    * @param string $type
    * @return bool
    */
    public function sendMail($user, $type) {
        /*try {
                // タイトル取得
                $subject = config('mail.subject.'. $type);
            
                // メール送信
                Mail::send('emails.template'. $type, ['user' => $user], function($message) use ($user) {
                    $message->to($user['email'], $user['name'])->subject($subject);
                });
                return true;
        } catch (Exception $e) {
                // メール送信に失敗した場合
                return false;
        }*/
        return true;
    }
    
}