<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taskboard extends Model
{
    protected $table = 'taskboard';
    protected $primaryKey = 'taskboardId';

    protected $fillable = [
        'taskboardName',
        'creatorId',
        'updaterId'
    ];

    public function taskboardUsers()
    {
        return $this->hasMany(TaskboardUser::class, 'taskboardId');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'taskboardId');
    }
    
}
