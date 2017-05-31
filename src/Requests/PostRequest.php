<?php

namespace NAdminPanel\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $id = $this->route()->parameter('post');

        if($this->method() == 'PUT' || $this->method() == 'PATCH') {

            $name = 'required|max:255|unique:posts,title,'.$id;

        } else {

            $name = 'required|max:255|unique:posts,title';

        }

        return [
            'title'  =>  $name
        ];
    }
}
