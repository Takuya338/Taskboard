<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'taskId';

    protected $fillable = [
        'taskboardId',
        'content',
        'taskStatus',
        'executorId',
        'creatorId',
        'updaterId'
    ];

    public function taskboard()
    {
        return $this->belongsTo(Taskboard::class, 'taskboardId');
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'executorId');
    }
}

