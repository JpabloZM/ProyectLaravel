<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'blog_category_id');
    }
}
