<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('taskboard_user', function (Blueprint $table) {
            // 既存の外部キー制約を削除
            $table->dropForeign(['userId']);

            // 新しいカスケード削除オプションを持つ外部キー制約を追加
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taskboard_user', function (Blueprint $table) {
            // 新しい外部キー制約を削除
            $table->dropForeign(['userId']);

            // 元の外部キー制約を復元
            $table->foreign('userId')->references('userId')->on('users');
        });
    }
};
