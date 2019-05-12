<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Post;

class BlogController extends Controller
{
    protected $limit = 5;

    public function index(){

        $categories = Category::with(['posts' => function($query){
            $query->published();
        }])->orderBy('title', 'asc')->get();

        $posts = Post::with('author')->latestFirst()->published()->simplePaginate($this->limit);

        return view('blog.index', compact('posts', 'categories'));
    }

    public function category($id){

        $categories = Category::with(['posts' => function($query){
            $query->published();
        }])->orderBy('title', 'asc')->get();

        $posts = Post::with('author')->latestFirst()->published()->where('category_id', $id)->simplePaginate($this->limit);

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        return view('blog.show', compact('post'));
    }
}
