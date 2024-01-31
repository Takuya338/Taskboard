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
    Route::get('users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('users/deletes', [UserController::class, 'deletes'])->name('users.deletes');
    Route::get('users/{id}/password/reset', [PasswordController::class, 'reset'])->name('users.password.reset');

    // ログイン情報変更
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [PasswordController::class, 'change'])->name('password.change');
    Route::post('/password/change', [PasswordController::class, 'update'])->name('password.update');

    // タスクボード管理
    Route::resource('taskboards', TaskBoardController::class);
    Route::get('taskboards/{id}/delete', [TaskBoardController::class, 'destroy'])->name('taskboards.destroy');
    
    // タスクボード
    Route::get('taskboards/{id}', [TaskBoardController::class, 'taskboard'])->name('board');

    // タスク管理
    Route::get('taskboards/{id}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('taskboards/{id}/tasks/create', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('taskboards/{taskboardId}/user/{userId}/tasks/{taskId}/status/{taskStatus}', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});

                                         

// testページへ遷移
Route::get('test', function () {
    //return view('top');
    return view('taskboards.newtaskboard');
});

