<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:pending,in-progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
            'assigned_by' => 'nullable|exists:users,id',
            'due_date'    => 'nullable|date',
        ];
    }
}
