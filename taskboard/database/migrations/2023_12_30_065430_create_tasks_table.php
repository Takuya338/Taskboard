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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('taskId');
            $table->unsignedBigInteger('taskboardId');  // 符号なしのBig Integerに変更
            //$table->foreign('taskboardId')->references('taskboardId')->on('taskboard')->onDelete('cascade');
            $table->text('content');
            $table->string('taskStatus');
            $table->unsignedBigInteger('executorId');  // 符号なしのBig Integerに変更
            //$table->foreign('executorId')->references('userId')->on('users');
            $table->unsignedBigInteger('creatorId');  // 必要に応じて型を修正
            $table->unsignedBigInteger('updaterId');  // 必要に応じて型を修正
            $table->timestamps();
            $table->foreign('taskboardId')->references('taskboardId')->on('taskboard')->onDelete('cascade');
            $table->foreign('executorId')->references('userId')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
