<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;

class AddUserToTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'array','min:1'],
            'user_id.*' => ['required','numeric','distinct','exists:users,id'],
            'org_id' => ['required', 'numeric', 'exists:orgs,id'],
            'team_id' => ['required','numeric','exists:teams,id']
        ];
    }
}
