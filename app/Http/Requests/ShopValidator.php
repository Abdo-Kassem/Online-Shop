<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopValidator extends FormRequest
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
        return [//like this assiut-manflout-25 mohamed street
            'name'=>'required|string|unique:shops,name',
            'address'=>'required|regex:/^([A-Za-z]{4,11})(\,[A-Za-z]+)*(\s[0-9]+)*(\s[A-Za-z]+)+$/',
            'post_number'=>'required|digits_between:5,5',
            'sended_person_email'=>'required|email',
        ];
    }
    public function messages(){
        return [
            'name.required'=>'you must enter shop name',
            'shopName.string'=>'must be string',
            'address.required'=>'must enter address',
            'address.regex'=>'please enter valide address',
            'post_number.required'=>'must enter postNumber',
            'post_number.digits_between'=>'must be five digits',
            'sended_person_email.required'=>'must enter email',
            'sended_person_email.email'=>'must be email'
        ];
    }
}
