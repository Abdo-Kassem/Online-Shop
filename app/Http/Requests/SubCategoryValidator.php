<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryValidator extends FormRequest
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
            'subcategoryName'=>'required|regex:/^([a-zA-Z\']+)(\s[a-zA-Z]+)*$/',
            'categoryID'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'subcategoryName.required'=>'name must enter',
            'subcategoryName.regex'=>'must be string',
            'categoryID.required'=>'name must enter',
        ];
    }
}
