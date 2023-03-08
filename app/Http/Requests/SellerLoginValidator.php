<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerLoginValidator extends FormRequest
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
            'id'=>'required',
            'email'=>'required|email',
            'password'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'id.required'=>'must enter your national ID',
            'email.required'=>'must enter email',
            'email.email'=>'must be email',
            'password.required' => 'must this field',
        ];
    }
}
