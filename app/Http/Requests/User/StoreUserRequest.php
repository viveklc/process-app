<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => ['nullable','string','email:filter','unique:users,email'],
            'phone' => ['nullable','numeric','digits_between:10,12'],
            'role_id' => ['required','numeric','exists:roles,id'],
            'is_org_admin' => ['nullable','in:1,2'],
            'password' => ['required','alpha_num','confirmed','min:6'],
            'is_colleague_of_user_id' => ['nullable','array','min:1'],
            'is_colleague_of_user_id.*' => ['nullable','numeric','exists:users,id','distinct'],
            'reports_to_user_id' => ['nullable','array','min:1'],
            'reports_to_user_id.*' => ['nullable','numeric','exists:users,id','distinct']
        ];
    }
}
