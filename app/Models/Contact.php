<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($contact) {
            Cache::tags(['contacts'])->flush();
        });
    }
}
