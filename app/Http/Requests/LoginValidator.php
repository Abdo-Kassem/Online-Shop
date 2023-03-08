<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginValidator extends FormRequest
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
            'email'=>'required|email:dns',
            'password'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'email must enter',
            'email.email'=>'must be email',
            'password.required' => 'must this field',
        ];
        
    }
}
