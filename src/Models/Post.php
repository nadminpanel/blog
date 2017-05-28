<?php

namespace NAdminPanel\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'description', 'featured', 'category_id',
        'user_id', 'source', 'published_at'
    ];

    public function category()
    {
        return $this->belongsTo('NAdminPanel\Blog\Models\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('NAdminPanel\Blog\Models\Tag');
    }
}
