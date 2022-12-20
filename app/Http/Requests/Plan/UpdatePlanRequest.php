<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdatePlanRequest extends FormRequest
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
        [$keys, $values] = Arr::divide(\App\Models\PaymentPlan::ADDITIONAL_DETAILS);
        $additonalDetails =[];
        foreach($keys as $key) {
            $additonalDetails[$key] = [
                'nullable'
            ];
        }

        $rules= [
            'plan_name' => ['required','string',Rule::unique('payment_plans')->ignore($this->plan->id),'max:50','min:3'],
            'plan_description' => ['nullable','string'],
            'plan_features' => ['nullable','string'],
            'plan_price' => ['required','numeric'],
            'valid_from' => ['required','date_format:Y-m-d','date'],
            'valid_to' => ['required','date_format:Y-m-d','date','after:valid_from'],
            'status' => ['required','string','in:active,in-active']
        ];
        $rules += array_merge($rules,$additonalDetails);

        return $rules;
    }
}
