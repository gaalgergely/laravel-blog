<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'rules' => 'required'
            ])
            ->add('slug', 'text', [
                'rules' => 'required|unique:categories' . (($this->request->isMethod('PUT')) ? ',id,'.$this->request->route()->parameter('category') : '')
            ])
            ->add('submit', 'submit', [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
