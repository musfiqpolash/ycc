<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productAdd extends FormRequest
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
            'product_price.*' => 'required|numeric',
            'product_color.*' => 'required',
            'product_size.*' => 'required',
//            'product_label' => 'required',
//            'carrierName' => 'required',
            'product_discount_price.*' => 'nullable|numeric',
            'product_image.*' => 'required|image|dimensions:width=263,height=390',
            'product_details_image1.*' => 'required|image|dimensions:width=50,height=50',
            'product_details_image2.*' => 'required|image|dimensions:width=480,height=600',
            'product_details_image3.*' => 'required|image|dimensions:width=1024,height=1024',
        ];
    }
}
