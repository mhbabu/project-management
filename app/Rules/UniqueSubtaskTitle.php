<?php

namespace App\Rules;

use App\Models\Subtask;
use Illuminate\Contracts\Validation\Rule;

class UniqueSubtaskTitle implements Rule
{
    protected $taskId;
    protected $subtaskId;

    public function __construct($taskId, $subtaskId = null)
    {
        $this->taskId    = $taskId;
        $this->subtaskId = $subtaskId;
    }

    public function passes($attribute, $value)
    {
        // Check if the subtask title is unique within the specified task
        return !Subtask::where('task_id', $this->taskId)
                    ->where('title', $value)
                    ->when($this->subtaskId, function($query) {
                        $query->where('id', '<>', $this->subtaskId);
                    })
                    ->exists();
    }

    public function message()
    {
        return 'The subtask title has already been taken.';
    }
}
