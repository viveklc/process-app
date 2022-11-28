<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamProcessRequest extends FormRequest
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
            'process_id' => ['required', 'array','min:1'],
            'process_id.*' => ['required','numeric','distinct','exists:processes,id'],
            // 'team_id' => ['required', 'numeric', 'exists:teams,id'],
            'valid_from' => ['required','date_format:Y-m-d','date','after_or_equal:today'],
            'valid_to' => ['required','date_format:Y-m-d','date','after:valid_from'],
        ];
    }
}
