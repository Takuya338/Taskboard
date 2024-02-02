<?php

namespace Database\Factories;

use App\Models\Taskboard;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskboardFactory extends Factory
{
    protected $model = Taskboard::class;

    public function definition()
    {
        return [
            'taskboardName' => 'タスクボード',
            'creatorId' => 1,
            'updaterId' => 1
        ];
    }
}
