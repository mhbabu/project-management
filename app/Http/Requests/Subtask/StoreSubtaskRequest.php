<?php

namespace App\Http\Requests\Subtask;

use App\Models\User;
use App\Rules\UniqueSubtaskTitle;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubtaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'task_id'     => 'required|exists:tasks,id',
            'title'       => [
                'required',
                'string',
                'max:255',
                new UniqueSubtaskTitle($this->input('task_id'), $this->route('subtask_id')) // Pass subtask_id if updating
            ],
            'description' => 'nullable|string',
            'assigned_to' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!$user || $user->type !== 'developer') {
                        $fail('Please select a valid developer.');
                    }
                },
            ],
            'due_date'    => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:today'
            ],
        ];
    }

    public function messages()
    {
        return [
            'task_id.exists'          => 'The selected task does not exist.',
            'due_date.after_or_equal' => 'The due date must be today or a future date.',
        ];
    }
}
