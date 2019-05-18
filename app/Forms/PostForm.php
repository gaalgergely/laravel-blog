<?php

namespace App\Forms;

use App\Category;
use Kris\LaravelFormBuilder\Form;

class PostForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text')
            ->add('slug', 'text')
            ->add('excerpt', 'textarea')
            ->add('body', 'textarea')
            ->add('image')
            ->add('published_at', 'datetime-local', [
                'label' => 'Publish Date'
            ])
            ->add('category_id', 'select', [
                'label' => 'Category',
                'choices' => Category::pluck('title', 'id')->toArray(),
                'empty_value' => '=== Select category ==='
            ])
            ->add('hr', 'hr')
            ->add('submit', 'submit', [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
