<?php

namespace App\Http\Requests\DMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
        [$keys, $values] = Arr::divide(\App\Models\DMS\Project::ADDITIONAL_DETAILS);
        $additonalDetails =[];
        foreach($keys as $key) {
            $additonalDetails[$key] = ['nullable'];
        }

        $rules= [
            'project_name' => ['required','string',Rule::unique('mysql2.projects','project_name')->ignore($this->project->id)],
            'project_status' => ['required'],
            'is_public' => ['required','in:1,2']
        ];

        $rules += array_merge($rules,$additonalDetails);

        return $rules;
    }
}
