<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class StoreOrgRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-org');
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
            'plan_id' => [
                'nullable',
                'exists:payment_plans,id'
            ],
            'address' => [
                'nullable'
            ],
            'image_url' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048'
            ],
            'is_premium' => [
                'nullable',
                'integer',
                'max:191',
                'in:1,2'
            ],
            'attachments' => ['nullable','array','min:1'],
            'attachments.*' => ['file'],
        ];
    }
}
