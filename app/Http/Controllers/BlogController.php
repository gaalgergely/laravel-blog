<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use App\Post;

class BlogController extends Controller
{
    protected $limit = 5;

    public function index(){

        $posts = Post::with('author', 'category', 'tags', 'comments')->latestFirst()->published()->filter(request()->only(['term', 'month', 'year']))->simplePaginate($this->limit);

        return view('blog.index', compact('posts'));
    }

    public function category(Category $category){

        $categoryName = $category->title;

        $posts = $category->posts()->with('author', 'category', 'tags', 'comments')->latestFirst()->published()->simplePaginate($this->limit);

        return view('blog.index', compact('posts', 'categoryName'));
    }

    public function author(User $author)
    {
        $authorName = $author->name;

        $posts = $author->posts()->with('author', 'category', 'tags', 'comments')->latestFirst()->published()->simplePaginate($this->limit);

        return view('blog.index', compact('posts', 'authorName'));
    }

    public function tag(Tag $tag)
    {
        $tagName = $tag->name;

        $posts = $tag->posts()->with('author', 'category', 'tags', 'comments')->latestFirst()->published()->simplePaginate($this->limit);

        return view('blog.index', compact('posts', 'tagName'));
    }

    public function show(Post $post)
    {
        $post->increment('view_count');

        $postComments = $post->comments()->simplePaginate(5);

        return view('blog.show', compact('post', 'postComments'));
    }
}
