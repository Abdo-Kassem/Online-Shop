<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerItemValidator extends FormRequest
{

    /**
     * create this class to validate item that create by seller because option of seller deffirent 
     * from option of admin
     */
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
            'itemName'=>'required|min:3|max:20',
            'image'=>'mimes:jpeg,JPG,png,gif|required|max:255',
            'price'=>'required|numeric',
            'details'=>'required',
            'discount'=>'required_with_all:start_time,end_time',
            'start_time'=>'nullable|after_or_equal:'.now(),
            'end_time'=>'nullable|after:start_time',
        ];
    }
    public function messages()
    {
        return [
            'itemName.required'=>'please enter item name',
            'itemName.min'=>'min length is 3 character',
            'itemName.max'=>'max length is 20 character',
            'image.mims'=>'must choose image',
            'image.required'=>'image must enter',
            'image.max'=>'image name length must less than 255',
            'price.required'=>'must enter salary',
            'price.numeric'=>'salary must be digits contain 0:9',
            'datails.required'=>'must enter details',
            'discount.required_with_all'=>'must enter start and end time of discount',
            'start_time.after'=>'must be > current datetime',
            'end_time.after'=>'must be > start_time',
        ];
    }
}
