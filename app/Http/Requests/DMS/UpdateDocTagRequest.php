<?php

namespace App\Http\Requests\DMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocTagRequest extends FormRequest
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
        return [
            'document_tag_name' => ['required','string','min:2','unique:document_tags,document_tag_name',Rule::unique('document_tags')->ignore($this->id)],
            'document_tag_type' => ['required','string']
        ];
    }
}
