<?php

namespace NAdminPanel\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use SoftDeletes, HasSlug;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'description', 'featured', 'category_id',
        'user_id', 'source', 'published_at', 'feature_image_path'
    ];

    public function user()
    {
        return $this->belongsTo('NAdminPanel\AdminPanel\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('NAdminPanel\Blog\Models\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('NAdminPanel\Blog\Models\Tag');
    }

    public function getPublishedAtAttribute($value)
    {
        if($value == null) {
            return '';
        } else {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('m/d/Y g:i A');
        }
    }

    public function setPublishedAtAttribute($value)
    {
        if($value == '' || $value == null) {
            $this->attributes['published_at'] = null;
        } else {
            $this->attributes['published_at'] = Carbon::createFromFormat('m/d/Y g:i A', $value);
        }
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
