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

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
