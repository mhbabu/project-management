<?php

namespace App\Http\Requests\Project;

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
            'title'          => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'team_leader_id' => 'nullable|exists:users,id',
        ];
    }
}
