<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'actable_id',
        'actable_type',
        'user_id',
    ];

    public function actable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function follow()
    {
        return $this->belongsTo(Follow::class);
    }

    public function like()
    {
        return $this->belongsTo(Like::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
