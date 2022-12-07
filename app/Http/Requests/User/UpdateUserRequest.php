<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'org_id' => ['required','numeric','exists:orgs,id'],
            'name' => ['required','string','max:50','min:2'],
            'username' => ['required','string',Rule::unique('users','username')->ignore($this->user->id)],
            'email' => ['nullable','string','email:filter',Rule::unique('users','email')->ignore($this->user->id)],
            'phone' => ['nullable','string'],
            'role_id' => ['required','numeric','exists:roles,id'],
            'is_org_admin' => ['nullable'],
            // 'password' => ['required','alpha_num','confirmed','min:6'],
            'is_colleague_of_user_id' => ['required','array','min:1'],
            'is_colleague_of_user_id.*' => ['required','numeric','exists:users,id','distinct'],
            'reports_to_user_id' => ['required','array','min:1'],
            'reports_to_user_id.*' => ['required','numeric','exists:users,id','distinct']
        ];
    }
}
