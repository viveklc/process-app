<?php

namespace App\Http\Requests\Process\instances\step;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStepInstaceRequest extends FormRequest
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

            'name' => ['required','string','min:2','max:100'],
            'description' => ['nullable','string'],
            'sequence' => ['required','numeric'],
            'before_step_instance_id' => ['nullable','exists:step_instances,id'],
            'after_step_instance_id' => ['nullable','exists:step_instances,id'],
            'is_substep' => ['nullable','in:1,2'],
            'is_child_of_step_id' => ['required_if:is_substep,1'],
            'attachments' => ['nullable','array','min:1'],
            'attachments.*' => ['file'],
            'is_mandatory' => ['nullable'],
            'is_conditional' => ['nullable','in:1,2'],
            'planned_start_on' => ['nullable','date_format:Y-m-d','date'],
            'planned_finish_on' => ['nullable','date_format:Y-m-d','date','after:planned_start_on'],
            'actual_start_on' => ['nullable','date_format:Y-m-d','date','after_or_equal:today'],
            'actual_finish_on' => ['nullable','date_format:Y-m-d','date','after:actual_start_on'],
            // 'status' => ['required','in:active,in-active']
        ];
    }
}
