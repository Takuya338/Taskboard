<?php

use Illuminate\Support\Str;
return [
    'taskboard' => [
        'status' => [
            'todo' => 0,             // 実行前
            'doing' => 1,            // 実行中
            'done' => 2,             // 終了
            'cancel' => -1,          // 中止
        ],
        'status_jp' => [
            'todo' => '実行前',      // 実行前
            'doing' => '実行中',     // 実行中
            'done' => '終了',        // 終了
            'cancel' => '中止',      // 中止
        ],
    ],
    'user' => [
        'type' => [
            'admin' => 1,            // 管理者
            'user' => 0,             // 利用者
        ],
        'type_jp' => [
            'admin' => '管理者',      // 管理者
            'user' => '利用者',       // 利用者
        ],
        'status' => [
            'active' => 0,            // 正常利用者
            'first' => 1,             // 初期利用者
            'reset' => 9,             // リセット
            'delete' => -1,           // 削除
        ],
        'status_jp' => [
            'active' => '',           // 正常利用者
            'first' => '未ログイン',   // 初期利用者
            'reset' => 'パスワードリセット済',     // リセット
            'delete' => '削除',        // 削除
        ],
    ],
    'mail' => [
        'subject' => [
            'register' => 'ユーザー登録完了',
            'update' => 'ユーザー情報の更新',
            'delete' => 'ユーザー情報の削除',
            'reset_password' => 'パスワードのリセット',
            'change_password' => 'パスワードの変更',
        ],
        'template' => [
            'register' => 'emails.register',
            'update' => 'emails.update',
            'delete' => 'emails.delete',
            'password' => 'emails.password',
        ],
    ],
];