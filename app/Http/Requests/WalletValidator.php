<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletValidator extends FormRequest
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
            'wallet_approach'=>'in:we,vodafone,fawry',
            'phone_number'=>'required|regex:/(01)[0-9]{9}$/|unique:phones,phone_number'
        ];
    }
    public function messages()
    {
        return [
            'wallet_approach.in'=>'must be on of three specific values',
            'phone_number.required'=>'must enter phone number',
            'phone_number.regex'=>'not phone number',
            
        ];
    }
}
