<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use App\Post;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {

    $post = Post::published()->get()->random();

    $hours = rand(0, 24);
    $datetime = $post->published_at->modify("+{$hours} hours");

    return [
        'post_id' => $post->id,
        'author_name' => $faker->name,
        'author_email' => $faker->email,
        'author_url' => rand(0, 5) > 2 ? $faker->url : null,
        'body' => $faker->paragraphs(rand(1, 5), true),
        'created_at' => $datetime,
        'updated_at' => $datetime,
    ];
});
