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

    protected $limit = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category', 'author')->latest()->paginate($this->limit);
        return view('backend.blog.index', compact('posts'));
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

        $request->user()->posts()->create($form->getFieldValues());
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

        $post = Post::findOrFail($id);
        $post->update($form->getFieldValues());

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
        return redirect()->route('backend.blog.index')->with('trash-message', ['Your post was moved to trash!', $id]);
    }

    public function restore($id)
    {
        Post::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('backend.blog.index')->with('message', 'Your post was restored!');
    }
}
