<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentSeo extends Model
{
    protected $table = 'content_seo';

    protected $fillable = [
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

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
