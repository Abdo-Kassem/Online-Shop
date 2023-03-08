<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderValidator extends FormRequest
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
            'send_time'=>'required|after_or_equal:'.now()
        ];
    }
    public function messages()
    {
        return [
            'send_time.required'=>'send time must enter',
            'send_time.after_or_equal'=>'send time must be current date or at the future'
        ];
    }
}
