<?php

namespace App\Http\Requests\Subtask;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubtaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Set to false if you want to authorize specific users/roles
    }

    public function rules()
    {
        return [
            'task_id'     => 'required|exists:tasks,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in-progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'assigned_by' => 'required|exists:users,id',
            'due_date'    => 'nullable|date',
        ];
    }
}
