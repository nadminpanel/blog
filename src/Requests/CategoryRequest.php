<?php

namespace NAdminPanel\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $id = $this->route()->parameter('category');

        if($this->method() == 'PUT' || $this->method() == 'PATCH') {

            $name = 'required|max:255|regex:"^[a-zA-Z]+$"|unique:categories,name,'.$id;

        } else {

            $name = 'required|max:255|regex:"^[a-zA-Z]+$"|unique:categories,name';

        }

        return [
            'name'  =>  $name
        ];
    }
}
