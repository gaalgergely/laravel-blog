<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CommentForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('author_name', 'text', [
                'rules' => 'required|max:255',
                'label' => 'Name'
            ])
            ->add('author_email', 'email', [
                'rules' => 'required|max:255|email',
                'label' => 'Email'
            ])
            ->add('author_url', 'url', [
                'rules' => 'max:255|url',
                'label' => 'Website'
            ])
            ->add('body', 'textarea', [
                'rules' => 'required',
                'label' => 'Comment'
            ])
            ->add('submit', 'submit', [
                'label' => 'Submit',
                'attr' => ['class' => 'btn btn-large btn-success']
            ]);
    }
}
