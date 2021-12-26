<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'subcategory' => 'required|not_in:default',
            'pro_name' => 'required|max:20|min:5|unique:products,name',
            'pro_price' => 'required',
            'sale_date_before' => 'nullable|date|after:today',
            'colors' => 'min:2|max:4',
            'pro_image' => 'mimes:png,jpg,jpeg|size:100'
        ];
    }

    public function messages()
    {
        return [
            'subcategory.required' => 'Subcategory is required!',
            'subcategory.not_in' => 'Subcategory is not valid!',
            'pro_name.required' => 'Product Name is required!',
            'pro_name.max' => 'Product Name should be less than 20 characters!',
            'pro_name.min' => 'Product Name should be greater than 5 characters!',
            'pro_name.unique' => 'Product Name is already exists!',
            'pro_price.required' => 'Product Price is required!',
            'sale_date_before.after' => 'Date should be greater than today!',
            'colors.min' => 'Please choose minimum 2 product colors!',
            'colors.max' => 'Please choose maximum 4 colors!',
            'pro_image.mimes' => 'File should be type of png, jpg or jpeg format!',
            'pro_image.size' => 'File size should not be greater than 100kb!'
        ];
    }
}
