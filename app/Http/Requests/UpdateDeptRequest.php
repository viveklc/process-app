<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
class UpdateDeptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(!auth()->user()->can('update-dept'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'org_id' => [
                'required',
                'exists:orgs,id'
            ],
            'name' => [
                'required',
                'string',
                'max:191'
            ],
            'description' => [
                'required',
                'longText'
            ]
        ];
    }
}
