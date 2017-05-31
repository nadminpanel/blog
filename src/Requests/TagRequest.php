<?php

namespace NAdminPanel\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
        $id = $this->route()->parameter('tag');

        if($this->method() == 'PUT' || $this->method() == 'PATCH') {

            $name = 'required|max:255|unique:tags,name,'.$id;

        } else {

            $name = 'required|max:255|unique:tags,name';

        }

        return [
            'name'  =>  $name
        ];
    }
}
