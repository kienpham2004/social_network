<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'caption',
        'total_like',
    ];

    const UNLIKED = 0;
    const LIKED = 1;

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hashtags()      
    {
        return $this->belongsToMany(Hashtag::class);
    }

    public function activities()
    {
        return $this->morphToMany(Activity::class, 'actable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
}
