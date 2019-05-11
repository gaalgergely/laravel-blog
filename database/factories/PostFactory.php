<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Post;
use Faker\Generator as Faker;
use App\User;

$factory->define(Post::class, function (Faker $faker) {

    $datetime = $faker->dateTimeThisYear();

    return [
        'author_id' => function(){
            return User::all()->random();
        },
        'title' => $faker->sentence(rand(8, 12)),
        'excerpt' => $faker->text(rand(250, 300)),
        'body' => $faker->paragraphs(rand(10, 15), true),
        'slug' => $faker->slug,
        'image' => rand(0,1) == 1 ? 'Post_Image_' . rand(1, 5) . '.jpg' : null,
        'created_at' => $datetime,
        'updated_at' => $datetime
    ];
});
