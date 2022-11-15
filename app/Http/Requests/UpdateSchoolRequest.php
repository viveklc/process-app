<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update-school');
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
            'description' => [
                'required'
            ],
            "link" => "nullable|url",
            "country_id" => "nullable|exists:countries,id",
            "state_id" => "nullable|exists:states,id",
            "city_id" => "nullable|exists:cities,id",
            'school_image_url' => [
                'nullable',
                'image',
                'mimes:jpeg, png, jpg',
                'max:2048'
            ]
        ];
    }
}
