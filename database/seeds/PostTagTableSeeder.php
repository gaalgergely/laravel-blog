<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Tag;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();
        $tags = Tag::pluck('id')->all();
        $tagsCount = count($tags)-1;

        foreach($posts as $post)
        {
            shuffle($tags);
            $offset = rand(0, $tagsCount);
            $length = rand(0, $tagsCount-$offset);
            $tagsToAttach = array_slice($tags, $offset, $length);
            foreach($tagsToAttach as $tag)
            {
                $post->tags()->attach($tag);
            }
        }
    }
}
