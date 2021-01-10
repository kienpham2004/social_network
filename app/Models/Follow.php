<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'user_id',
        'follow_id',
    ];

    const FOLLOW = 1;
    const UNFOLLOW = 0;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } 

    public function friend()
    {
        return $this->belongsTo(User::class, 'follow_id');
    } 

    public function activities()
    {
        return $this->morphMany(Activity::class, 'actable');
    }

    public function actFollows()
    {
        return $this->hasMany(Activity::class, 'actable_id', 'id');
    }  
}
