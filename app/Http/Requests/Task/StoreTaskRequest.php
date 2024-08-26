<?php

namespace App\Http\Requests\Task;

use App\Models\User;
use App\Models\Task;
use App\Rules\UniqueTaskTitle;
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
            'title'       => [
                'required',
                'string',
                'max:255',
                new UniqueTaskTitle($this->input('project_id'), $this->input('assigned_to'))
            ],
            'description' => 'nullable|string',
            'status'      => 'nullable|in:pending,in_progress,completed',
            'assigned_to' => [
                'nullable',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!$user || $user->type !== 'developer') {
                        $fail('Please select a valid developer.');
                    }
                },
            ],
            'due_date'    => [
                'required_if:assigned_to,!=,null',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:today'
            ],
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'project_id.exists'       => 'The selected project does not exist.',
            'due_date.required_if'    => 'The due date field is required when assigning the task to a user.',
            'due_date.after_or_equal' => 'The due date must be today or a future date.',
        ];
    }
}
