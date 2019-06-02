<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Category;
use App\Post;
use App\Tag;
use App\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * IMPORTANT!
         * The database seed is written to handle the task centralized
         * It should use:
         * php artisan db:seed
         * -> You can not run the seeds separately, it could cause errors!
         */
        if (App::environment() === 'production') exit();

        Eloquent::unguard();

        // Truncate all tables, except migrations
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            if ($table->{'Tables_in_' . env('DB_DATABASE')} !=='migrations')
                DB::table($table->{'Tables_in_' . env('DB_DATABASE')})->truncate();
        }

        $this->call(UsersTableSeeder::class);
        factory(User::class, 5)->create();
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);

        $this->call(CategoriesTableSeeder::class);
        factory(Category::class, 10)->create();

        factory(Post::class, 100)->create();

        factory(Tag::class, 20)->create();
        $this->call(PostTagTableSeeder::class);

        factory(Comment::class, 250)->create();
    }
}
