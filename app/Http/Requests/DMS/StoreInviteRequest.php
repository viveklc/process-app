<?php

namespace App\Http\Requests\DMS;

use Illuminate\Foundation\Http\FormRequest;

class StoreInviteRequest extends FormRequest
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
            'user_email' => ['required'],
            'invited_for_role' => ['required','string'],
            'invite_valid_upto' => ['required','date_format:Y-m-d','date','after_or_equal:today']
        ];
    }
}
