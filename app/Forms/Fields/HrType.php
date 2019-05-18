<?php


namespace App\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class HrType extends FormField
{
    protected function getTemplate()
    {
        return 'fields.hr';
    }
}