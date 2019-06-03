<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class TagForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
            'rules' => 'required|max:255|unique:tags' . (($this->request->isMethod('PUT')) ? ',id,'.$this->request->route()->parameter('tag') : '')
            ])
            ->add('slug', 'text', [
                'rules' => 'required|max:255|unique:tags' . (($this->request->isMethod('PUT')) ? ',id,'.$this->request->route()->parameter('tag') : '')
            ])
            ->add('submit', 'submit', [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
