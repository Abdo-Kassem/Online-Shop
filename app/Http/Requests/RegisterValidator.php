<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidator extends FormRequest
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
            'email'=>'required|email|unique:users,email',
            'userName'=>'required|alpha|unique:users,name|max:11|min:4',
            'password'=>'required|min:8|max:20|confirmed|required_with:password_confirmation',
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
            'password.required'=>'password must enter',
            'password.min'=>'password at least 8 character',
            'password.max'=>'password max 20 character',
            'password.required_with'=>'password and confirm password must equal',
            'address.required'=>'must enter address',
            'address.regex'=>'please enter valide address',
        ];
    }
}
