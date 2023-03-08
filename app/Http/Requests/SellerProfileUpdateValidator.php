<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerProfileUpdateValidator extends FormRequest
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
            'sellerName'=>'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)$/',
            'id'=>'required|digits_between:14,14',
            'phone.*'=>'required|regex:/(01)[0-9]{9}/|distinct',
            'email'=>'required|email',
            'password'=>'required',
            'acountType'=>'digits_between:0,1',
            'image'=>'nullable|mimes:jpeg,JPG,png,webp'
        ];
    }
    public function messages(){
        return [
            'sellerName.required'=>'must enter your name',
            'sellerName.regex'=>'name must be firstName and lastName',
            'id.required'=>'must enter your national ID',
            'id.digits_between'=>'not national ID',
            'id.unique'=>'exist and personal id can not repeate',
            'phone.*.required'=>'must enter phone',
            'phone.*.regex'=>'must be phone number',
            'phone.*.distinct'=>'phon must not repeat',
            'email.required'=>'must enter email',
            'email.email'=>'must be email',
            'password.required'=>'must enter password',
            'acountType.digits_between'=>'must be 0 or one',
            'image.mimes'=>'must be image of type jpeg,JPG,png',
        ];
    }
}
