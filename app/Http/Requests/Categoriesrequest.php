<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class Categoriesrequest extends FormRequest
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
        $id = $this->route('category');
        return Category::rules($id);
        // return [
        //     //
        // ];
    }



    public function messages()
    {
        return [
            'name.unique' => 'The Category is Already Exists',
            'required' => 'the field (:attribute) is required '
        ];
    }
}
