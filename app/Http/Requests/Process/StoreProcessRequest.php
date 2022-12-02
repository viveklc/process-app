<?php

namespace App\Http\Requests\Process;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreProcessRequest extends FormRequest
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
        [$keys, $values] = Arr::divide(\App\Models\Process\Process::ADDITIONAL_DETAILS);
        $additonalDetails =[];
        foreach($keys as $key) {
            $additonalDetails[$key] = ['nullable'];
        }

        $rules = [
            'org_id' => ['required','numeric','exists:orgs,id'],
            'process_name' => ['required','string','unique:processes','max:50','min:3'],
            'process_description' => ['nullable','string','max:500','min:1'],
            'total_duration' => ['required','numeric'],
            'valid_from' => ['required','date_format:Y-m-d','date','after_or_equal:today'],
            'valid_to' => ['required','date_format:Y-m-d','date','after:valid_from'],
            'status' => ['required','string','in:active,in-active'],
            'attachments' => ['nullable','array','min:1'],
            'attachments.*' => ['file'],
        ];
        $rules += array_merge($rules,$additonalDetails);

        return $rules;
    }
}
