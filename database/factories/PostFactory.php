<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'caption' => 'habshd',
        'total_like' => 0,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
    ];
});
