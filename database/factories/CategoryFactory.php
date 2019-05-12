<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => ucfirst($faker->unique()->words(rand(1,2), true)),
        'slug' => $faker->unique()->slug
    ];
});
