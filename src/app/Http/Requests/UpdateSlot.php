<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlot extends FormRequest
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
            'slot_id' => 'required|integer',
            'name' => 'required|max:255',
            'slot_capacity' => 'integer',
            'total_lists' => 'integer|min:0',
            'start_date' => 'date|after:today',
            'end_date' => 'date|after:today',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }
}
