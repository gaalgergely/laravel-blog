<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class AccountForm extends Form
{
    public function buildForm()
    {
        $user = auth()->user();

        $this
            ->add('name', 'text', [
                'rules' => 'required'
            ])
            ->add('slug', 'text', [
                'rules' => 'required|unique:users,id,'.$user->id
            ])
            ->add('email', 'email', [
                'rules' => 'required|email|unique:users,id,'.$user->id
            ])
            ->add('password', 'repeated', [
                'type' => 'password',
                'first_options' => [
                    'value' => ''
                ],
                'second_options' => [
                    'value' => ''
                ]
            ])
            ->add('role', 'static', [
                'tag' => 'p',
                'value' => $user->roles->first()->display_name,
            ])
            ->add('bio', 'textarea')
            ->add('submit', 'submit', [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
