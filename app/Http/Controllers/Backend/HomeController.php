<?php

namespace App\Http\Controllers\Backend;

use App\Forms\AccountForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class HomeController extends BackendController
{
    use FormBuilderTrait;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.home');
    }

    public function edit(Request $request, FormBuilder $formBuilder)
    {
        $user = $request->user();

        $form = $formBuilder->create(AccountForm::class, [
            'method' => 'PUT',
            'url' => route('backend.account.update'),
            'model' => $user
        ]);
        return view('backend.user.edit', compact('form'));
    }

    public function update(Request $request)
    {
        $form = $this->form(AccountForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        // Or automatically redirect on error. This will throw an HttpResponseException with redirect
        $form->redirectIfNotValid();

        $user = $request->user();
        $user->update($form->getFieldValues());

        return redirect()->route('home')->with('success', 'Your account was updated successfully!');
    }
}
