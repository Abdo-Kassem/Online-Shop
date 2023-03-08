<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryValidator extends FormRequest
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
            'categoryName'=>'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|unique:categories,name',
            'categorySellingCost'=>'required',
            'image'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'categoryName.required'=>'name can not empty',
            'categoryName.regex'=>'name must be string',
            'categoryName.unique'=>'category name must be not exist befor',
            'categorySellingCost.numeric'=>'cost required'
        ];
    }
}
