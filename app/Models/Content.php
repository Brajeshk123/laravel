<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content_type',
        'excerpt',
        'content',
        'featured_image',
        'banner_image',
        'author_id',
        'status',
        'published_at',
        'is_featured',
        'allow_comments',
        'view_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'robots',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
    ];

    protected $casts = [

        'published_at' => 'datetime',

        'is_featured' => 'boolean',

        'allow_comments' => 'boolean',

    ];

    /**
     * Author
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Categories
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'content_category'
        );
    }

    /**
     * Tags
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'content_tag'
        );
    }

    public function seo()
    {
        return $this->hasOne(ContentSeo::class);
    }
}
