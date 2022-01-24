<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($item) {
            Cache::tags(['news', 'tags'])->flush();           
        });

        static::updated(function ($item) {
            Cache::tags(['news', 'tags'])->flush();                    
        });
        
        static::deleted(function ($item) {
            Cache::tags(['news', 'tags'])->flush();         
        });
    }

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
