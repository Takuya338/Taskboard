<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskboardUser extends Model
{
    use HasFactory;
    
    protected $table = 'taskboard_user';

    protected $fillable = [
        'taskboardId',
        'userId',
        'creatorId',
        'updaterId'
    ];

    public function taskboard()
    {
        return $this->belongsTo(Taskboard::class, 'taskboardId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
