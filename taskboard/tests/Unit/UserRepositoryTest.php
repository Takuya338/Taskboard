<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository; // サービスクラスを適切に置き換えてください
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    // ユーザー一覧情報取得のテスト
    public function testSearchUser()
    {
        // テスト用ユーザーデータの作成
        $user1 = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'userStatus' => config('code.user.status.delete'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $user2 = User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'userStatus' => config('code.user.status.delete'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $user3 = User::create([
            'name' => 'Bob Williams',
            'email' => 'will@example.com',
            'userStatus' => 1,
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $user4 = User::create([
            'name' => 'Ali Williams',
            'email' => 'Alice2@example.com',
            'userStatus' => 1,
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $user5 = User::create([
            'name' => 'Alice Johnson',
            'email' => 'johnson@example.com',
            'userStatus' => 1,
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);

        // UserRepositoryのインスタンスを作成
        $repository = new UserRepository();

        // メソッドを実行して結果を取得
        $results = $repository->searchUser('Alice');

        // 結果の検証
        $this->assertCount(2, $results); // 検索結果が1件であることを確認
        $this->assertEquals('Ali Williams', $results[0][1]); // ユーザー名が正しいことを確認
        $this->assertEquals('Alice2@example.com', $results[0][2]); // メールアドレスが正しいことを確認
        $this->assertEquals('Alice Johnson', $results[1][1]); // ユーザー名が正しいことを確認
        $this->assertEquals('johnson@example.com', $results[1][2]); // メールアドレスが正しいことを確認
    }
    
    // createUserメソッドのテスト(正常系)
    public function testCreateUserSuccessfully()
    {
        $service = new UserRepository(); // サービスクラスのインスタンス化

        // Authファサードのモックを作成
        Auth::shouldReceive('id')
            ->andReturn(1); // このメソッドが1を返すように設定
        
        // モックデータ
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret',
            'user_type' => 'admin'
        ];

        // ユーザー作成
        $userArray = $service->createUser($data);

        // ユーザーがデータベースに存在することを確認
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);

        // 返された配列が期待通りであることを確認
        $this->assertEquals($data['name'], $userArray['name']);
        $this->assertEquals($data['email'], $userArray['email']);
        $this->assertEquals($data['user_type'], $userArray['userType']);
        $this->assertEquals(config('code.user.status.first'), $userArray['userStatus']);
        $this->assertEquals(1, $userArray['creatorId']);
        $this->assertEquals(1, $userArray['updaterId']);
        // ... その他のフィールドも同様に確認する
    }
    
    // createUserメソッドのテスト(異常系)
    public function testCreateUserWithException()
    {
        $service = new UserRepository(); // サービスクラスのインスタンス化

        // ユーザー作成時に例外を投げるようにモック設定
        $this->mock(User::class, function ($mock) {
            $mock->shouldReceive('save')->andThrow(new \Exception());
        });

        // モックデータ
        $data = [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'user_type' => 'admin'
        ];

        // ユーザー作成
        $result = $service->createUser($data);

        // 空配列が返されることを確認
        $this->assertEmpty($result);
    }
    
    // getUserByIdメソッドのテスト
    public function testGetUserById()
    {
        // テスト用ユーザーデータの作成
        $user = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'userStatus' => config('code.user.status.delete'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);

        // UserRepositoryのインスタンスを作成
        $repository = new UserRepository();

        // メソッドを実行して結果を取得
        $result = $repository->getUserById($user->userId);

        // 結果の検証
        $this->assertEquals($user->name, $result['name']);
        $this->assertEquals($user->email, $result['email']);
        $this->assertEquals($user->userStatus, $result['userStatus']);
        $this->assertEquals($user->userType, $result['userType']);
        $this->assertEquals($user->creatorId, $result['creatorId']);
        $this->assertEquals($user->updaterId, $result['updaterId']);
    }
    
    // updateUserメソッドのテスト
    public function testUpdateUser()
    {
         // Authファサードのモックを作成
        Auth::shouldReceive('id')
            ->andReturn(1); // このメソッドが1を返すように設定
        
        
        // テスト用ユーザーデータの作成
        $user = User::create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'password' => bcrypt('originalpassword'),
            'userType' => 1,
            'userStatus' => 1,
            'creatorId' => 1,
            'updaterId' => 1
            // その他必要なフィールド...
        ]);

        // UserRepositoryのインスタンスを作成
        $repository = new UserRepository();

        // 更新データ
        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'updatedpassword',
            'user_type' => 2,
            'user_status' => 2
        ];

        // メソッドを実行して結果を取得
        $updatedUser = $repository->updateUser($user->userId, $updateData);
        
        // 結果の検証
        $this->assertEquals('Updated Name', $updatedUser['name']);
        $this->assertEquals('updated@example.com', $updatedUser['email']);
        $this->assertEquals(2, $updatedUser['userType']);
        $this->assertEquals(2, $updatedUser['userStatus']);
        // その他の属性についても同様に検証
    }
    
    // deleteUserメソッドのテスト
    public function testDeleteUser()
    {
        // テスト用ユーザーデータの作成
        $user = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'userStatus' => config('code.user.status.delete'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);

        // UserRepositoryのインスタンスを作成
        $repository = new UserRepository();

        // メソッドを実行して結果を取得
        $deletedUser = $repository->deleteUser($user->userId);

        // 結果の検証
        $this->assertEquals($user->email, $deletedUser['email']); // メールアドレスが元のままであることを確認
        $this->assertEquals(config('code.user.status.delete'), $deletedUser['userStatus']); // ステータスが更新されていることを確認
        $this->assertDatabaseHas('users', [
            'userId' => $user->userId,
            'email' => $user->userId . '@delete.com' // メールアドレスが更新された状態でデータベースに存在することを確認
        ]);
    }
    
    // getUserByEmailメソッドのテスト
    public function testGetUserByEmail()
    {
        // テスト用ユーザーデータの作成
        $user = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'userStatus' => config('code.user.status.delete'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        // UserRepositoryのインスタンスを作成
        $repository = new UserRepository();

        // メソッドを実行して結果を取得
        $getUser = $repository->getUserByEmail('alice@example.com');
        
        // 結果の検証
        $this->assertEquals($user->userId, $getUser);
    }
    
    // hashWordメソッドのテスト
    public function testHashWord()
    {
        $repository = new UserRepository();

        $password = 'my-secret-password';
        $hashedPassword = $repository->hashWord($password);

        // Assert that the hashed password is not the same as the plain password
        $this->assertNotEquals($password, $hashedPassword);

        // Use password_verify to check that the hash corresponds to the original password
        $this->assertTrue(password_verify($password, $hashedPassword));
    }
    
    public function testGetLoginUserId()
    {
        $user = User::factory()->create(['creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('id')->andReturn($user->userId);

        $repository = new UserRepository();
        $this->assertEquals($user->userId, $repository->getLoginUserId());
    }

    public function testChangePassword()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('id')->andReturn($user->userId);

        $repository = new UserRepository();
        $repository->changePassword('newpassword', $user->userId);

        $updatedUser = User::find($user->userId);
        $this->assertTrue(Hash::check('newpassword', $updatedUser->password));
    }

    public function testGetLoginUserType()
    {
        $user = User::factory()->create(['userType' => config('code.user.status.first'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('id')->andReturn($user->userId);

        $repository = new UserRepository();
        $this->assertEquals(config('code.user.status.first'), $repository->getLoginUserType());
    }

    public function testGetLoginUser()
    {
        $user = User::factory()->create(['userType' => config('code.user.status.first'),'userStatus'=>1,'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('id')->andReturn($user->userId);

        $repository = new UserRepository();
        $loginUser = $repository->getLoginUser();

        $this->assertEquals($user->userType, $loginUser['userType']);
        $this->assertEquals($user->userStatus, $loginUser['userStatus']);
    }
    
}
