<?php

namespace NAdminPanel\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;
use NAdminPanel\Blog\Models\Post;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('post');
        $user = auth()->user();

        if($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $post = Post::find($id);
            return (($user->hasPermissionTo('edit post') && $post->isOwner()) || $user->hasRole('developer'));
        }

        return ($user->hasPermissionTo('create post') || $user->hasRole('developer'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('post');

        if($this->method() == 'PUT' || $this->method() == 'PATCH') {

            $name = 'required|max:255|unique:posts,title,'.$id;
            $slug = 'required|regex:"/^[a-z0-9]+(?:-[a-z0-9]+)*$/"';

        } else {

            $name = 'required|max:255|unique:posts,title';
            $slug = '';

        }

        return [
            'title'     =>  $name,
            'slug'      =>  $slug,
            'short_description' => 'required',
            'description' => 'required',
            'published_at' => 'required'
        ];
    }
}
