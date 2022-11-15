<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-city');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'country_id' => [
                'required',
                'exists:countries,id'
            ],
            'state_id' => [
                'required',
                'exists:states,id'
            ],
            'name' => [
                'required',
                'string',
                'max:191'
            ],
            'image' => [
                'required',
                'image',
                'mimes:jpeg, png, jpg',
                'max:2048'
            ],
        ];
    }
}
