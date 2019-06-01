<?php

namespace App\Http\Controllers\Backend;

use App\Forms\UserForm;
use App\Http\Requests\UserDestroyRequest;
use App\User;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class UserController extends BackendController
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('posts')->orderBy('created_at', 'desc')->paginate($this->limit);
        return view('backend.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(UserForm::class, [
            'method' => 'POST',
            'url' => route('backend.user.store')
        ]);
        return view('backend.user.edit', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $this->form(UserForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        // Or automatically redirect on error. This will throw an HttpResponseException with redirect
        $form->redirectIfNotValid();

        $user = User::create($form->getFieldValues());
        $user->attachRole($request->role);

        return redirect()->route('backend.user.index')->with('success', 'User was created successfully!');
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
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $user = User::findOrFail($id);

        $form = $formBuilder->create(UserForm::class, [
            'method' => 'PUT',
            'url' => route('backend.user.update', ['id' => $id]),
            'model' => $user
        ]);
        return view('backend.user.edit', compact('form'));
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
        $form = $this->form(UserForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        // Or automatically redirect on error. This will throw an HttpResponseException with redirect
        $form->redirectIfNotValid();

        /**
         * @todo check if these lines can be merged into one command line (for post and category also ... for example)
         */
        $user = User::findOrFail($id);
        $user->update($form->getFieldValues());
        /**
         * @todo protect root user from changing its role
         */
        $user->detachRoles()->attachRole($request->role);

        return redirect()->route('backend.user.index')->with('success', 'User was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDestroyRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $deleteOption = $request->delete_option;
        $selectedUser = $request->selected_user;

        if($deleteOption == 'delete')
        {
            $user->posts()->withTrashed()->forceDelete();
        }
        elseif($deleteOption == 'attribute')
        {
            /**
             * @todo check if user exists
             * @todo maybe author_id should be user_id in some cases
             */
            $user->posts()->update(['author_id' => $selectedUser]);
        }
        $user->delete();

        return redirect()->route('backend.user.index')->with('success', 'User was deleted successfully!');
    }

    public function confirm(UserDestroyRequest $request, $id)
    {
        $user = User::findOrFail($id);

        return view('backend.user.confirm', compact('user'));
    }
}
