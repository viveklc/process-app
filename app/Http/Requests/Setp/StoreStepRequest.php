<?php

namespace App\Http\Requests\Setp;

use Illuminate\Foundation\Http\FormRequest;

class StoreStepRequest extends FormRequest
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
            'dept_id' => ['required','numeric','exists:depts,id'],
            'team_id' => ['required','numeric','exists:teams,id'],
            'name' => ['required','string','min:2','max:100'],
            'total_duration' => ['required','numeric'],
            'description' => ['nullable','string'],
            'sequence' => ['required','numeric'],
            'before_step_id' => ['nullable','exists:steps,id'],
            'after_step_id' => ['nullable','exists:steps,id'],
            'is_substep' => ['nullable','in:1,2'],
            'substep_of_step_id' => ['required_if:is_substep,1'],
            'attachments' => ['nullable','array','min:1'],
            'attachments.*' => ['file'],
            'is_mandatory' => ['nullable'],
            'is_conditional' => ['nullable','in:1,2'],
            'status' => ['required','in:active,in-active']
        ];
    }
}
