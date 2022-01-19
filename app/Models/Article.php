<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
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

    public function hasOwner()
    {
        return !Auth::check() ? false : ($this->owner_id == Auth::user()->id);
    }

    public static function allByOwner()
    {
        return self::where('owner_id', Auth::user()->id);
    }

    public function sendAllMailNotifyNewArticle($message)
    {
        User::sendAllMailNotifyArticle($this, $message);
    }

    public function comments()
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }

    public function histories()
    {
        return $this->belongsToMany(User::class, ArticleHistory::class)->withPivot(['created_at', 'before', 'after']);
    }

    public function getTypeItem()
    {
        return 'article';
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }
}
