<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($item) {
            Cache::tags(['comments'])->flush();           
        });
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function articles()
    {
        return $this->morphedByMany(Article::class, 'commentable');
    }

    public function news()
    {
        return $this->morphedByMany(News::class, 'commentable');
    }
}
