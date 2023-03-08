<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerRegisterValidator extends FormRequest
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
            'name'=>'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)$/',
            'id'=>'required|digits_between:14,14|unique:sellers,id',
            'phone1'=>'required|regex:/(01)[0-9]{9}/|unique:phones,phone_number',
            'phone2'=>'required|regex:/(01)[0-9]{9}/|different:phone1',
            'email'=>'required|email|unique:sellers,email',
            'reset_email'=>'required_with:email|same:email',
            'password'=>'required|regex:/^[A-Z]([0-9]{6,18})[A-Z]$/',
            'reset_password'=>'required_with:password|same:password',
            'acount_type'=>'digits_between:0,1',
            'image'=>'required|mimes:jpeg,jpg,png,webp'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'must enter your name',
            'name.regex'=>'name must be firstName and lastName',
            'id.required'=>'must enter your national ID',
            'id.digits_between'=>'not national ID',
            'id.unique'=>'exist and personal id can not repeate',
            'phone1.required'=>'must enter first phone number',
            'phone1.regex'=>'phone number must be between 11 and 20 digits',
            'phone2.required'=>'must enter second phone number',
            'phone2.regex'=>'phone number must be between 11 and 20 digits',
            'phone2.different'=>'please enter different phone number',
            'email.required'=>'must enter email',
            'email.email'=>'must be email',
            'email.unique'=>'email already exist',
            'reset_email.required_with'=>'please type email again',
            'reset_email.same'=>'please enter email again',
            'password.required'=>'must enter password',
            'password.regex'=>'password must start with capital letter and end with capital letter and any digit in middle',
            'reset_password.required_with'=>'must type password again',
            'reset_password.same'=>'reset-password must be the same password',
            'acount_type.digits_between'=>'must be 0 or one',
            'image.mimes'=>'must be image of type jpeg,JPG,png',
            'image.required'=>'must chosse image'
        ];
    }
}
