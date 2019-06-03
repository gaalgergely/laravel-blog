<?php

namespace App\Http\Controllers\Backend;

use App\Forms\PostForm;
use App\Post;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class BlogController extends BackendController
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $onlyTrashed = false;
        if(($status = $request->get('status')) && $status == 'trash')
        {
            $posts = Post::onlyTrashed()->with('category', 'author')->latest()->paginate($this->limit);
            $onlyTrashed = true;
        }
        elseif($status == 'published')
        {
            $posts = Post::published()->with('category', 'author')->latest()->paginate($this->limit);
        }
        elseif($status == 'scheduled')
        {
            $posts = Post::scheduled()->with('category', 'author')->latest()->paginate($this->limit);
        }
        elseif($status == 'draft')
        {
            $posts = Post::draft()->with('category', 'author')->latest()->paginate($this->limit);
        }
        elseif($status == 'own')
        {
            $posts = $request->user()->posts()->with('category', 'author')->latest()->paginate($this->limit);
        }
        else
        {
            $posts = Post::withTrashed()->with('category', 'author')->latest()->paginate($this->limit);
        }
        return view('backend.blog.index', compact('posts', 'onlyTrashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(PostForm::class, [
            'method' => 'POST',
            'url' => route('backend.blog.store')
        ]);
        return view('backend.blog.edit', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $this->form(PostForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        // Or automatically redirect on error. This will throw an HttpResponseException with redirect
        $form->redirectIfNotValid();

        $data = $form->getFieldValues();

        $post = $request->user()->posts()->create($data);
        $post->attachTags($data['post_tags']);

        return redirect()->route('backend.blog.index')->with('success', 'Your post was created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @todo the controller does not receive Post object
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $post = Post::findOrFail($id);

        $form = $formBuilder->create(PostForm::class, [
            'method' => 'PUT',
            'url' => route('backend.blog.update', ['id' => $id]),
            'model' => $post
        ]);
        return view('backend.blog.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form = $this->form(PostForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        // Or automatically redirect on error. This will throw an HttpResponseException with redirect
        $form->redirectIfNotValid();

        $data = $form->getFieldValues();

        $post = Post::findOrFail($id);
        $post->update($data);
        $post->attachTags($data['post_tags']);

        return redirect()->route('backend.blog.index')->with('success', 'Your post was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->back()->with('trash-message', ['Your post was moved to trash!', $id]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDestroy($id)
    {
        Post::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back()->with('message', 'Your post was deleted permanently!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        Post::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with('message', 'Your post was restored!');
    }
}
