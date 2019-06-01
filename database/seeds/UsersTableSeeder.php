<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;
use Faker\Factory;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        User::create([
            'name' => 'Gaál Gergely',
            'slug' => 'gaal-gergely',
            'email' => 'gaal.gergely1@gmail.com',
            'email_verified_at' => now(),
            'password' => 'password',
            'bio' => $faker->text(rand(250, 300)),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'John Doe',
            'slug' => 'john-doe',
            'email' => 'john@doe.net',
            'email_verified_at' => now(),
            'password' => 'password',
            'bio' => $faker->text(rand(250, 300)),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Jane Doe',
            'slug' => 'jane-doe',
            'email' => 'jane@doe.net',
            'email_verified_at' => now(),
            'password' => 'password',
            'bio' => $faker->text(rand(250, 300)),
            'remember_token' => Str::random(10),
        ]);
    }
}
