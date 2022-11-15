<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-country');
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
                'max:191',
                'unique:countries,name'
            ],
            'flag_image' => [
                'required',
                'image',
                'mimes:jpeg, png, jpg',
                'max:2048'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'default_language_id' => 'default language',
        ];
    }
}
