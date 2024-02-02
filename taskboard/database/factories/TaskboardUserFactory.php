<?php

namespace Database\Factories;

use App\Models\TaskboardUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskboardUserFactory extends Factory
{
    protected $model = TaskboardUser::class;

    public function definition()
    {
        return [
            'creatorId' => 1,
            'updaterId' => 1
        ];
    }
}