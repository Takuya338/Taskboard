<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    
    protected $model = Task::class;
     /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => 'sample',
            'taskStatus' => config('code.taskboard.status.todo'),
            'creatorId' => 1,
            'updaterId' => 1
        ];
    }
}