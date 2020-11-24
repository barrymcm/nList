<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSlot extends FormRequest
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
            'event_id' => 'required|integer',
            'name' => 'string',
            'slot_capacity' => 'integer|required',
            'start_date' => 'date|after_or_equal:today',
            'start_time' => 'required',
            'end_date' => 'date|after_or_equal:today',
            'end_time' => 'required',
        ];
    }
}
