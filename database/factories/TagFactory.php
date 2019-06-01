<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->unique()->words(rand(1,2), true)),
        'slug' => $faker->unique()->slug,
    ];
});
