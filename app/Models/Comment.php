<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_name',
        'email',
        'article_id'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
} 