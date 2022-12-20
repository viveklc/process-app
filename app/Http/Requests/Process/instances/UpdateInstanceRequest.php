<?php

namespace App\Http\Requests\process\instances;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInstanceRequest extends FormRequest
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
            'process_instance_name' => ['required','string','max:100','min:3',
                Rule::unique('process_instances','process_instance_name')->ignore($this->process_instance->id)
                ->where('process_id',$this->process->id)
            ],
            'team_id' => ['required_without:assigned_to_user_id','exists:teams,id'],
            'assigned_to_user_id' => ['required_without:team_id','exists:users,id'],
            'start_date' => ['required','date_format:Y-m-d\TH:i','date'],
            'due_date' => ['required','date_format:Y-m-d\TH:i','date','after:start_date'],
            'attachments' => ['nullable','array','min:1'],
            'attachments.*' => ['file'],

        ];
    }
}
