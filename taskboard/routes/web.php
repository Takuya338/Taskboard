<?php
/*
* web.php
* create  Takuya Goto
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TaskBoardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

// 認証関連
Route::get('/', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

// 認証が必要なルートグループ
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // ユーザー管理
    Route::resource('users', UserController::class);
    Route::delete('users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('users/{id}/password/reset', [PasswordController::class, 'reset'])->name('users.password.reset');

    // ログイン情報変更
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [ProfileController::class, 'update']);
    Route::get('/password/change', [PasswordController::class, 'change'])->name('password.change');
    Route::put('/password/change', [PasswordController::class, 'update']);

    // タスクボード管理
    Route::resource('taskboards', TaskBoardController::class);
    Route::delete('taskboards/{id}/delete', [TaskBoardController::class, 'destroy'])->name('taskboards.destroy');

    // タスク管理
    Route::get('taskboards/{id}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('taskboards/{id}/tasks/create', [TaskController::class, 'store']);
    Route::patch('taskboards/{id}/tasks/{taskId}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});

                                         

// testページへ遷移
Route::get('test', function () {
    /*$data = [
        'page_title' => 'テストページ',
        'centence' => 'これはテストを行うページです。',
        'button_url' => '/taskboard/create/comfirm',
        'button_name' => '確認',
    ];*/
    // return view('templetes.done',$data);
    //return view('top');
    return view('taskboard');
});

