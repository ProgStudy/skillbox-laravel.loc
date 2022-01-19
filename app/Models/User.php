<?php

namespace App\Models;

use App\Mail\ArticleHandlerMail;
use App\Mail\NotificationNewArticleMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

use Log;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public static function hasRole($prefix)
    {
        return (Auth::user() && Auth::user()->roles->whereIn('prefix', $prefix)->first());        
    }

    public static function sendAllMailNotifyArticle(Article $article, $message)
    {
        try {
            Mail::to(self::select('email')->get()->pluck('email')->toArray())
                ->send(new ArticleHandlerMail($article, $message));
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
        }
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'owner_id', 'id');
    }
}
