<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'url_image_story',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
