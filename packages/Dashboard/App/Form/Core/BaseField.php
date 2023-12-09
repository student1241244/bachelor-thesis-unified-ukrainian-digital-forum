<?php

namespace Packages\Dashboard\App\Form\Core;

use AdamWathan\BootForms\Elements\GroupWrapper;

abstract class BaseField
{
    protected $lang = null;

    abstract public function render() : GroupWrapper;

    public function translated($lang)
    {
        $this->lang = $lang;

        return $this;
    }
}
