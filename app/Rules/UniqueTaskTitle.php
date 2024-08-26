<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Task;

class UniqueTaskTitle implements Rule
{
    protected $projectId;
    protected $assignedTo;
    protected $taskId;

    public function __construct($projectId, $assignedTo, $taskId = null)
    {
        $this->projectId = $projectId;
        $this->assignedTo = $assignedTo;
        $this->taskId = $taskId;
    }

    public function passes($attribute, $value)
    {
        $query = Task::where('project_id', $this->projectId)
                     ->where('title', $value)
                     ->where('assigned_to', $this->assignedTo);

        // Exclude the current task ID from the check
        if ($this->taskId) {
            $query->where('id', '!=', $this->taskId);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'The task title has already been taken.';
    }
}
