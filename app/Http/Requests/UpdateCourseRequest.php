<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update-course');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:191'
            ],
            'short_description' => [
                'nullable'
            ],
            'long_description' => [
                'nullable'
            ],
            "tags" => "nullable|array|exists:tags,id",
            'course_image_url' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ];
    }
}
