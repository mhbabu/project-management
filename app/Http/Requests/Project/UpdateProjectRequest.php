<?php

namespace App\Http\Requests\Project;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'name'           => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'team_leader_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!$user || $user->type !== 'team-leader') {
                        $fail('The selected team leader is either invalid or not a team-leader.');
                    }
                },
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
            'team_leader_id.exists' => 'The selected team leader does not exist in our records.',
        ];
    }
}
