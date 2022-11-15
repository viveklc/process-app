<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
        [$keys, $values] = Arr::divide(\App\Models\Content\Book::ADDITIONAL_DETAILS);
        $additonalDetails =[];
        foreach($keys as $key) {
            $additonalDetails[$key] = [
                'nullable'
            ];
        }

        return [
            'subject_id' => [
                'required',
                'exists:subjects,id'
            ],
            'name' => [
                'required',
                'string',
                'max:191',
            ],
            'short_description' => [
                'required',
                'string',
                'max:250'
            ],
            'long_description' => [
                'required',
                'string',
                'max:500'
            ],
            'tags' => [
                'nullable',
                'string',
                'max:500'
            ],
            'front_image' => [
                'nullable',
                'image',
                'mimes:jpeg, png, jpg',
                'max:2048'
            ],
            'back_image' => [
                'nullable',
                'image',
                'mimes:jpeg, png, jpg',
                'max:2048'
            ],
            ...$additonalDetails
        ];
    }
}
