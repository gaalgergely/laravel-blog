<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create roles
         */
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin'
        ]);

        $editor = Role::create([
            'name' => 'editor',
            'display_name' => 'Editor'
        ]);

        $author = Role::create([
            'name' => 'author',
            'display_name' => 'Author'
        ]);
        /**
         * Attach roles to users
         */
        $users = User::all();
        $users[0]->attachRole($admin);
        $users[1]->attachRole($editor);
        $users[2]->attachRole($author);
        for($i=3;$i<$users->count();$i++)
        {
            $users[$i]->attachRole($author);
        }
    }
}
