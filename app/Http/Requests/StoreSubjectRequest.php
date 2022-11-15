<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-subject');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        [$keys, $values] = Arr::divide(\App\Models\Content\Subject::ADDITIONAL_DETAILS);
        $additonalDetails =[];
        foreach($keys as $key) {
        $additonalDetails[$key] = [
                'nullable'
            ];
        }

        return [
            'name' => [
                'required',
                'string',
                'max:191'
            ],
            'short_description' => [
                'required'
            ],
            'long_description' => [
                'nullable'
            ],
            "course_id" => "nullable|exists:courses,id",
            "level_id" => "nullable|exists:levels,id",
            "tags" => "required|array|exists:tags,id",
            'subject_image_url' => [
                'required',
                'image',
                'mimes:jpeg, png, jpg',
                'max:2048'
            ],
            ...$additonalDetails
        ];
    }
}
