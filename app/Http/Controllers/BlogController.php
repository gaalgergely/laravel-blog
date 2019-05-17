<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use App\Post;

class BlogController extends Controller
{
    protected $limit = 5;

    public function index(){

        $posts = Post::with('author')->latestFirst()->published()->simplePaginate($this->limit);

        return view('blog.index', compact('posts'));
    }

    public function category(Category $category){

        $categoryName = $category->title;

        $posts = $category->posts()->with('author')->latestFirst()->published()->simplePaginate($this->limit);

        return view('blog.index', compact('posts', 'categoryName'));
    }

    public function author(User $author)
    {
        $authorName = $author->name;

        $posts = $author->posts()->with('category')->latestFirst()->published()->simplePaginate($this->limit);

        return view('blog.index', compact('posts', 'authorName'));
    }

    public function show(Post $post)
    {
        $post->increment('view_count');
        return view('blog.show', compact('post'));
    }
}
