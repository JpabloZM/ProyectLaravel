<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'featured_image',
        'author_id',
        'blog_category_id',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? Storage::url($this->featured_image) : null;
    }

    public function isPublished()
    {
        return $this->published_at !== null && $this->published_at <= now();
    }
}
