<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminValidator extends FormRequest
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
        return [
            'name'=>'required|string',
            'email'=>'required|email:rfc,dns',
            'old_password'=>'required',
            'new_password'=>'nullable|regex:/^[A-Z][0-9]{6,18}[A-Z]/'
        ];
    }

    public function messages()
    {
        return [
            'email.email'=>'email format wronge',
            'new_password.regex'=>'must start capital letter and from 6 to 18 digit and end by capital letter',
        ];
    }
}
