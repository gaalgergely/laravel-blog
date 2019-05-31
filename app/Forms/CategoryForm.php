<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'rules' => 'required|max:255|unique:categories' . (($this->request->isMethod('PUT')) ? ',id,'.$this->request->route()->parameter('category') : '')
            ])
            ->add('slug', 'text', [
                'rules' => 'required|max:255|unique:categories' . (($this->request->isMethod('PUT')) ? ',id,'.$this->request->route()->parameter('category') : '')
            ])
            ->add('submit', 'submit', [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
