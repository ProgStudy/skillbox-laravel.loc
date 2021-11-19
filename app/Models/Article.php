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
        return $this->belongsToMany(Tag::class);
    }

    public function hasOwner()
    {
        return !Auth::check() ? false : ($this->owner_id == Auth::user()->id);
    }

    public static function allByOwner()
    {
        return self::where('owner_id', Auth::user()->id)->get();
    }

    public function sendAllMailNotifyNewArticle($message)
    {
        User::sendAllMailNotifyArticle($this, $message);
    }

}
