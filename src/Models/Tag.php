<?php

namespace NAdminPanel\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description'
    ];

    public function posts()
    {
        return $this->belongsToMany('NAdminPanel\Blog\Models\Post');
    }

}
