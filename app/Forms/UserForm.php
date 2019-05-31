<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'rules' => 'required'
            ])
            ->add('slug', 'text', [
                'rules' => 'required|unique:users' . (($this->request->isMethod('PUT')) ? ',id,'.$this->request->route()->parameter('user') : '')
            ])
            ->add('email', 'email', [
                'rules' => 'required|email|unique:users' . (($this->request->isMethod('PUT')) ? ',id,'.$this->request->route()->parameter('user') : '')
            ])
            ->add('password', 'repeated', [
                'type' => 'password',
                'first_options' => [
                    'rules' => 'required',
                    'value' => ''
                ],
                'second_options' => [
                    'rules' => 'required',
                    'value' => 'required'
                ]
            ])
            ->add('bio', 'textarea')
            ->add('submit', 'submit', [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
