<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Post;
use Faker\Generator as Faker;
use App\User;
use App\Category;

$factory->define(Post::class, function (Faker $faker) {

    $datetime = $faker->dateTimeThisYear();

    return [
        'author_id' => function(){
            return User::all()->random();
        },
        'category_id' => function(){
            return Category::all()->random();
        },
        'title' => $faker->sentence(rand(8, 12)),
        'excerpt' => $faker->text(rand(250, 300)),
        'body' => $faker->paragraphs(rand(10, 15), true),
        'slug' => $faker->unique()->slug,
        'image' => rand(0,5) > 3 ? 'Post_Image_' . rand(1, 5) . '.jpg' : null,
        'view_count' => rand(1, 10) * 10,
        'created_at' => $datetime,
        'updated_at' => $datetime,
        'published_at' => rand(0,4) == 0 ? $faker->dateTimeBetween('now', '+3 months') : (rand(0,4) == 0 ? null :$datetime)
    ];
});
