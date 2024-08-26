<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'team_leader_id'];

    public function teamLeader()
    {
        return $this->belongsTo(User::class, 'team_leader_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function subtasks()
    {
        return $this->hasManyThrough(
            Subtask::class,
            Task::class,
            'project_id', // Foreign key on the tasks table
            'task_id',    // Foreign key on the subtasks table
            'id',         // Local key on the projects table
            'id'          // Local key on the tasks table
        );
    }

    public function totalSubtasks()
    {
        return $this->subtasks()->count();
    }

    
}
