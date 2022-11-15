<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
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
        [$keys, $values] = Arr::divide(\App\Models\Admin\Department::ADDITIONAL_DETAILS);
        $additonalDetails =[];
        foreach($keys as $key) {
            $additonalDetails[$key] = [
                    'nullable'
                ];
        }

        return [
            'organization_id' => [
                'required',
                'exists:organizations,id'
            ],
            'name' => [
                'required',
                'string',
                'max:191',
                'unique:departments,name,'.request()->route('department')->id
            ],
            'description' => [
                'required',
                'string',
                'max:500'
            ],
            ...$additonalDetails
        ];
    }
}
