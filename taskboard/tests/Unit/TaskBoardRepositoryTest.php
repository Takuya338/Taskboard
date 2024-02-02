<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Taskboard;
use App\Models\TaskboardUser;
use App\Models\Task;
use App\Repositories\TaskBoardRepository; // サービスクラスを適切に置き換えてください
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TaskBoardRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    private $taskBoardRepository;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // TaskBoardRepository インスタンスの初期化
        $this->taskBoardRepository = new TaskBoardRepository();
        
    }
    
    public function testGetTaskboardListAsAdmin()
    {
        // 管理者ユーザーを作成し、認証する
        $adminUser = User::factory()->create(['userType' => config('code.user.type.admin'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('user')->andReturn($adminUser);

        // 必要に応じて、タスクボードのテストデータを作成する
        $user = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'userStatus' => config('code.user.status.delete'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $taskboard1 = Taskboard::create([
            'taskboardName' => 'タスクボード管理システム改修',
            'creatorId' => 1,
            'updaterId' => $user->userId
        ]);
        $taskboard2 = Taskboard::create([
            'taskboardName' => '新規タスクボードプロジェクト',
            'creatorId' => 1,
            'updaterId' => $user->userId
        ]);
        $taskboard3 = Taskboard::create([
            'taskboardName' => '勤怠管理システム改修',
            'creatorId' => 1,
            'updaterId' => $user->userId
        ]);

        // メソッドを実行
        $search = 'タスクボード';
        $result = $this->taskBoardRepository->getTaskboardList($search);
        $this->assertIsArray($result);
        $this->assertEquals(2,count($result));
        $this->assertEquals('タスクボード管理システム改修', $result[0][1]);
        $this->assertEquals('Alice Smith', $result[0][2]);
        $this->assertEquals('新規タスクボードプロジェクト', $result[1][1]);
        $this->assertEquals('Alice Smith', $result[1][2]);

    }

    public function testGetTaskboardListAsNonAdmin()
    {
        // 非管理者ユーザーを作成し、認証する
        $nonAdminUser = User::factory()->create(['userType' => config('code.user.type.user'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('user')->andReturn($nonAdminUser);
        Auth::shouldReceive('id')->andReturn($nonAdminUser->userId);

        // 必要に応じて、タスクボードのテストデータを作成する
        $user = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'userStatus' => config('code.user.status.delete'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $taskboard1 = Taskboard::create([
            'taskboardName' => 'タスクボード管理システム改修',
            'creatorId' => 1,
            'updaterId' => $user->userId
        ]);
        $taskboard2 = Taskboard::create([
            'taskboardName' => '新規タスクボードプロジェクト',
            'creatorId' => 1,
            'updaterId' => $user->userId
        ]);
        $taskboard3 = Taskboard::create([
            'taskboardName' => '勤怠管理システム改修',
            'creatorId' => 1,
            'updaterId' => $user->userId
        ]);
        $taskboardUser1 = TaskboardUser::create([
            'taskboardId' => $taskboard1->taskboardId,
            'userId' => Auth::id(),
            'creatorId' => $user->userId,
            'updaterId' => $user->userId
        ]);
        $taskboardUser2 = TaskboardUser::create([
            'taskboardId' => $taskboard2->taskboardId,
            'userId' => $user->userId,
            'creatorId' => $user->userId,
            'updaterId' => $user->userId
        ]);
        $taskboardUser3 = TaskboardUser::create([
            'taskboardId' => $taskboard3->taskboardId,
            'userId' => Auth::id(),
            'creatorId' => $user->userId,
            'updaterId' => $user->userId
        ]);

        // メソッドを実行
        $search = 'タスクボード';
        $result = $this->taskBoardRepository->getTaskboardList($search);
        $this->assertIsArray($result);
        $this->assertEquals(1,count($result));
        $this->assertEquals('タスクボード管理システム改修', $result[0][1]);
        $this->assertEquals('Alice Smith', $result[0][2]);

    }

    
    public function testCreateTaskboard()
    {
        $user = User::factory()->create(['userType' => config('code.user.status.first'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('users')->andReturn($user);
        Auth::shouldReceive('id')->andReturn($user->userId);
        
        $data = ['タスクボード名'];
        $response = $this->taskBoardRepository->createTaskboard($data);
        
        $this->assertIsArray($response);
        $this->assertEquals($data[0], $response['taskboardName']);
        $this->assertEquals($user->userId, $response['creatorId']);
        $this->assertEquals($user->userId, $response['updaterId']);
        $this->assertDatabaseHas('taskboard', ['taskboardName' => $data[0]]);
        
    }
    
    public function testGetTaskboard()
    {
        // 必要に応じて、タスクボードのテストデータを作成する
        $taskboard = Taskboard::create([
            'taskboardName' => 'タスクボード管理システム改修',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        $result = $this->taskBoardRepository->getTaskboard($taskboard->taskboardId);
        $this->assertIsArray($result);
        $this->assertEquals(1,count($result));
        $this->assertEquals($taskboard->taskboardId, $result[0][0]);
        $this->assertEquals('タスクボード管理システム改修', $result[0][1]);
        
    }
    
    public function testUpdateTaskboard()
    {
        // 非管理者ユーザーを作成し、認証する
        $nonAdminUser = User::factory()->create(['userType' => config('code.user.type.user'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('user')->andReturn($nonAdminUser);
        Auth::shouldReceive('id')->andReturn($nonAdminUser->userId);
        
        $taskboard = Taskboard::create([
            'taskboardName' => 'タスクボード管理システム改修',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        $data = [$taskboard->taskboardId, 'かんばんボード管理システム改修'];
        
        $result = $this->taskBoardRepository->updateTaskboard($data);
        
        $this->assertIsArray($result);
        $this->assertEquals($result['taskboardName'], $data[1]);
        $this->assertEquals($result['updaterId'], $nonAdminUser->userId);
        $this->assertDatabaseHas('taskboard', ['taskboardName' => $data[1], 'updaterId' => $nonAdminUser->userId]);
        
    }
    
    public function testDeleteTaskboard()
    {
        // 非管理者ユーザーを作成し、認証する
        $nonAdminUser = User::factory()->create(['userType' => config('code.user.type.user'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('user')->andReturn($nonAdminUser);
        Auth::shouldReceive('id')->andReturn($nonAdminUser->userId);
        
        $taskboard1 = Taskboard::create([
            'taskboardName' => 'タスクボード管理システム改修',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $taskboard2 = Taskboard::create([
            'taskboardName' => '新規タスクボードプロジェクト',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        $data = [$taskboard1->taskboardId, $taskboard2->taskboardId];
        
        $result = $this->taskBoardRepository->deleteTaskboard($data);
        
        $this->assertEquals($result, true);
        $this->assertDatabaseMissing('taskboard', ['taskboardId' => $taskboard1->taskboardId]);
        $this->assertDatabaseMissing('taskboard', ['taskboardId' => $taskboard2->taskboardId]);
        
    }
    
    public function testCreateOrUpdateTaskboardUsers()
    {
        // 非管理者ユーザーを作成し、認証する
        $nonAdminUser = User::factory()->create(['userType' => config('code.user.type.user'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('user')->andReturn($nonAdminUser);
        Auth::shouldReceive('id')->andReturn($nonAdminUser->userId);
        
        // ユーザー作成
        $user1 = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'userStatus' => config('code.user.status.first'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $user2 = User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'userStatus' => config('code.user.status.first'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        // タスクボード作成
        $taskboard = Taskboard::create([
            'taskboardName' => 'タスクボード管理システム改修',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        // 更新前のタスクボード利用者
        $taskboardUsers1 = TaskboardUser::create([
            'userId' => $user1->userId,
            'taskboardId' => $taskboard->taskboardId,
            'creatorId' => $user1->userId,
            'updaterId' => $user1->userId
        ]); 
        
        // 更新処理
        $data = [$user1->userId, $user2->userId];
        $result = $this->taskBoardRepository->createOrUpdateTaskboardUsers($taskboard->taskboardId, $data);
        
        // 更新後のタスクボード利用者
        $this->assertEquals($result, true);
        $this->assertDatabaseHas('taskboard_user', ['taskboardId' => $taskboard->taskboardId, 'userId' => $user1->userId, 'creatorId' => $user1->userId, 'updaterId' => $nonAdminUser->userId]);
        $this->assertDatabaseHas('taskboard_user', ['taskboardId' => $taskboard->taskboardId, 'userId' => $user2->userId, 'creatorId' => $nonAdminUser->userId, 'updaterId' => $nonAdminUser->userId]);
    }
    
    public function testDeleteTaskboardUsers()
    {
        // 非管理者ユーザーを作成し、認証する
        $nonAdminUser = User::factory()->create(['userType' => config('code.user.type.user'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('user')->andReturn($nonAdminUser);
        Auth::shouldReceive('id')->andReturn($nonAdminUser->userId);
        
        // ユーザー作成
        $user1 = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'userStatus' => config('code.user.status.first'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $user2 = User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'userStatus' => config('code.user.status.first'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        // タスクボード作成
        $taskboard = Taskboard::create([
            'taskboardName' => 'タスクボード管理システム改修',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        // 更新前のタスクボード利用者
        $taskboardUsers1 = TaskboardUser::create([
            'userId' => $user1->userId,
            'taskboardId' => $taskboard->taskboardId,
            'creatorId' => $user1->userId,
            'updaterId' => $user1->userId
        ]); 
        
        // 更新処理
        $data = [$user1->userId, $user2->userId];
        $result = $this->taskBoardRepository->deleteTaskboardUsers($taskboard->taskboardId, [$user1->userId,$user2->userId]);
        
        // 更新後のタスクボード利用者
        $this->assertEquals($result, true);
        $this->assertDatabaseMissing('taskboard_user', ['taskboardId' => $taskboard->taskboardId, 'userId' => $user1->userId, 'creatorId' => $user1->userId, 'updaterId' => $nonAdminUser->userId]);
        $this->assertDatabaseMissing('taskboard_user', ['taskboardId' => $taskboard->taskboardId, 'userId' => $user2->userId, 'creatorId' => $nonAdminUser->userId, 'updaterId' => $nonAdminUser->userId]);
    }
    
    public function testDeleteTaskboardUsersForAll()
    {
       // 非管理者ユーザーを作成し、認証する
        $nonAdminUser = User::factory()->create(['userType' => config('code.user.type.user'),'creatorId'=>1,'updaterId'=>1]);
        Auth::shouldReceive('user')->andReturn($nonAdminUser);
        Auth::shouldReceive('id')->andReturn($nonAdminUser->userId);
        
        // ユーザー作成
        $user1 = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'userStatus' => config('code.user.status.first'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        $user2 = User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'userStatus' => config('code.user.status.first'),
            'userType' => 1,
            'password' => 'password',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        // タスクボード作成
        $taskboard = Taskboard::create([
            'taskboardName' => 'タスクボード管理システム改修',
            'creatorId' => 1,
            'updaterId' => 1
        ]);
        
        // 更新前のタスクボード利用者
        $taskboardUsers1 = TaskboardUser::create([
            'userId' => $user1->userId,
            'taskboardId' => $taskboard->taskboardId,
            'creatorId' => $user1->userId,
            'updaterId' => $user1->userId
        ]); 
        
        // 更新処理
        $data = [$user1->userId, $user2->userId];
        $result = $this->taskBoardRepository->deleteTaskboardUsers($taskboard->taskboardId);
        
        // 更新後のタスクボード利用者
        $this->assertEquals($result, true);
        $this->assertDatabaseMissing('taskboard_user', ['taskboardId' => $taskboard->taskboardId, 'userId' => $user1->userId, 'creatorId' => $user1->userId, 'updaterId' => $nonAdminUser->userId]);
        $this->assertDatabaseMissing('taskboard_user', ['taskboardId' => $taskboard->taskboardId, 'userId' => $user2->userId, 'creatorId' => $nonAdminUser->userId, 'updaterId' => $nonAdminUser->userId]);
    }
}
