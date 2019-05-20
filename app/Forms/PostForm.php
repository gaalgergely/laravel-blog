<?php

namespace App\Forms;

use App\Category;
use App\Rules\CategoryExists;
use Carbon\Carbon;
use Kris\LaravelFormBuilder\Form;

class PostForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'rules' => 'required'
            ])
            ->add('slug', 'text', [
                'rules' => 'required|unique:posts'
            ])
            ->add('excerpt', 'textarea')
            ->add('body', 'textarea', [
                'rules' => 'required',
            ])
            ->add('image', 'imageupload', [
                'label_show' => false,
                'rules' => 'mimes:jpg,jpeg,bmp,png'
            ])
            ->add('published_at', 'text', [
                'label' => 'Publish Date',
                /*
                 * @todo think about this later when editing
                 */
                //'rules' => 'date_format:Y-m-d H:i:s',
                //'default_value' => Carbon::now(),
            ])
            ->add('category_id', 'select', [
                'label_show' => false,
                'choices' => Category::pluck('title', 'id')->toArray(),
                'empty_value' => '=== Select category ===',
                'rules' => ['required', new CategoryExists()]
            ])
            ->add('submit', 'submit', [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
