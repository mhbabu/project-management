<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in-progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'assigned_by' => 'required|exists:users,id',
            'due_date'    => 'nullable|date',
        ];
    }
}
