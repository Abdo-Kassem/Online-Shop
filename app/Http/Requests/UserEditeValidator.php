<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditeValidator extends FormRequest
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
            'email'=>'required|email|unique:users,email,'.$this->id,
            'userName'=>'required|string',
            'address'=>'required|regex:/^([A-Za-z]{4,11})(\,[A-Za-z]+)*(\s[0-9]+)*(\s[A-Za-z]+)+$/',
        ];
    }

    public function messages()
    {
        return [
            'email.required'=>'must enter email',
            'email.email'=>'must be email',
            'email.unique'=>'email already exist',
            'userName.required'=>'username must enter',
            'userName.alpha'=>'username must be character',
            'userName.unique'=>'username already exist',
            'userName.max'=>'less than 8 character',
            'userName.min'=>'at least 4 character',
            'address.required'=>'must enter address',
            'address.regex'=>'please enter valide address',
        ];
    }
}
