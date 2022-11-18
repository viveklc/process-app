<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
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
        $rules = [
            'user_id' => ['required', 'array'],
            'org_id' => ['required', 'numeric', 'exists:orgs,id'],
            'valid_from' => ['required'],
            'valid_to' => ['required']
        ];
        if ($this->method() === "POST") {
            $rules += ['team_name' => [
                'required', 'string', 'max:100', 'min:3',
                Rule::unique('teams', 'team_name')->where(function ($q) {
                    return $q->where('org_id', 1);
                })
            ]];
        }
        if ($this->method() === "PUT") {
            $rules += ['team_name' => [
                'required', 'string', 'max:100', 'min:3',
                Rule::unique('teams', 'team_name')->ignore($this->id)
                ->where(function ($q) {
                    return $q->where('org_id', 1);
                })
            ]];
        }


        return $rules;
    }
}
