<?php

namespace App\Forms;

use App\Role;
use App\Rules\RoleExistsRule;
use App\User;
use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $uniqueRule = (($this->request->isMethod('PUT')) ? ',id,'.$this->request->route()->parameter('user') : '');

        $selectedRole = (($this->model) ? User::find($this->request->route()->parameter('user'))->roles->first()->id : null);

        $requiredPassword = !is_null($this->model) ? '' : 'required';

        $this
            ->add('name', 'text', [
                'rules' => 'required'
            ])
            ->add('slug', 'text', [
                'rules' => 'required|unique:users' . $uniqueRule
            ])
            ->add('email', 'email', [
                'rules' => 'required|email|unique:users' . $uniqueRule
            ])
            ->add('password', 'repeated', [
                'type' => 'password',
                'first_options' => [
                    'value' => '',
                    'rules' => $requiredPassword
                ],
                'second_options' => [
                    'value' => '',
                    'rules' => $requiredPassword
                ]
            ]);
        /**
         * @todo protect root user from changing its role
         */
            $this->add('role', 'select', [
                'choices' => Role::pluck('display_name', 'id')->toArray(),
                'empty_value' => '=== Select role ===',
                'selected' => $selectedRole,
                'rules' => ['required', new RoleExistsRule()],
                'label' => 'Role'
            ])
            ->add('bio', 'textarea')
            ->add('submit', 'submit', [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
