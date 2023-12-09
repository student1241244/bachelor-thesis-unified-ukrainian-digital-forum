<?php

namespace Packages\Dashboard\App\Form;

use Packages\Dashboard\App\Form\Providers\Input;
use Illuminate\Database\Eloquent\Model;

class Field
{
    public static function input(Model $entity, string $label, string $name)
    {
        return (new Input($entity, $label, $name));
    }
}
