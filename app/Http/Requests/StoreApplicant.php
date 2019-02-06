<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicant extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'list_id' => 'required|integer',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:100',
            'dob' => 'required|date',
            'gender' => [
                'required',
                Rule::in('male', 'female')
            ]
        ];
    }
}
