<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function findBySlug($slug, $notSelectById = null)
    {
        return self::where('slug', $slug)->where(function($q) use ($notSelectById) {
            if ($notSelectById) $q->where('id', '!=', $notSelectById);
        })->first();
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function comments()
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }

    public function getTypeItem()
    {
        return 'news';
    }
}
