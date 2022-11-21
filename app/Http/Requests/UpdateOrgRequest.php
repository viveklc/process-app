<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
class UpdateOrgRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(!auth()->user()->can('update-org'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
                'required',
                'exists:plans,id'
            ],
            'address' => [
                'required'
            ],
            'image_url' => [
                'required',
                'image',
                'mimes:jpeg, png, jpg',
                'max:2048'
            ],
            'is_premium' => [
                'nullable',
                'integer',
                'max:191',
                'in:1,2'
            ]
        ];
    }
}
