<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamRequest extends FormRequest
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
            'valid_from' => ['required','date_format:Y-m-d','date','after_or_equal:today'],
            'valid_to' => ['required'],
            'team_name' =>  [
                'required', 'string', 'max:100', 'min:3',
                Rule::unique('teams', 'team_name')->where(function ($q) {
                    return $q->where('org_id', $this->request->get('org_id'));
                })
            ]
        ];
    }
}
