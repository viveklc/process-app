<?php

namespace App\Http\Requests\Process\instances;

use Illuminate\Foundation\Http\FormRequest;

class MassDestroyProcessInstanceRequest extends FormRequest
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
            'ids'   => 'required|array',
            'ids.*' => 'exists:process_instances,id',
        ];
    }
}
