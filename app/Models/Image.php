<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'photo_url',
        'photo_alt',
        'post_id',
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }
}
