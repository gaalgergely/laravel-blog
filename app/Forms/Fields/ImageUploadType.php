<?php


namespace App\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class ImageUploadType extends FormField
{
    protected function getTemplate()
    {
        return 'fields.imageupload';
    }

}