<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
        [$keys, $values] = Arr::divide(\App\Models\Content\Page::ADDITIONAL_DETAILS);
        $additonalDetails =[];
        foreach($keys as $key) {
            $additonalDetails[$key] = [
            'nullable'
            ];
        }

        return [
            'chapter_id' => [
                'required',
                'exists:chapters,id'
            ],
            'page_type' => [
                'required',
                'string',
                'max:191',
                'in:'.implode(",", array_keys(config('lms-config.page.page_type')))
            ],
            'page_content' => [
                'nullable',
                'string',
                'max:500'
            ],
            'page_content_url' => [
                'nullable',
                'string',
                'max:191',
                'url'
            ],
            'page_sequence' => [
                'nullable',
                'string',
                'max:191'
            ],
            'is_first' => [
                'nullable',
                'string',
                'max:191',
                'in:yes,no'
            ],
            'is_last' => [
                'nullable',
                'string',
                'max:191',
                'in:yes,no'
            ],
            'is_composite' => [
                'nullable',
                'string',
                'max:500'
            ],
            'is_conditional' => [
                'nullable',
                'string',
                'max:191',
            ],
            'tags' => [
                'nullable',
                'string',
                'max:500',
            ],
            'status' => [
                'required',
                'string',
                'max:191',
                'in:'.implode(",", array_keys(config('lms-config.page.page_status')))
            ],
            ...$additonalDetails
        ];
    }
}
