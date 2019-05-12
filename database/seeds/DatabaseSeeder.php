<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() === 'production') exit();

        Eloquent::unguard();

        // Truncate all tables, except migrations
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            if ($table->{'Tables_in_' . env('DB_DATABASE')} !=='migrations')
                DB::table($table->{'Tables_in_' . env('DB_DATABASE')})->truncate();
        }

        // $this->call(UsersTableSeeder::class);
        factory(\App\User::class, 5)->create();
        factory(\App\Category::class, 10)->create();
        factory(\App\Post::class, 100)->create();
    }
}
