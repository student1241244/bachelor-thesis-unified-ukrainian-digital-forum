<?php

namespace Packages\Dashboard\App\Form\Providers;

use AdamWathan\BootForms\Elements\GroupWrapper;
use BootForm;
use Packages\Dashboard\App\Form\Core\BaseField;
use Illuminate\Database\Eloquent\Model;

class Input extends BaseField
{
    private $entity;
    private $label;
    private $name;
    private $type = 'text';

    /**
     * Input constructor.
     *
     * @param Model $entity
     * @param string $label
     * @param string $name
     */
    public function __construct(Model $entity, string $label, string $name)
    {
        $this->entity = $entity;
        $this->label = $label;
        $this->name = str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $name);
    }

    public function render(): GroupWrapper
    {
        return BootForm::{$this->type}($this->label, $this->getFieldName())->defaultValue($this->getDefaultValue());
    }

    private function getFieldName()
    {
        if (strpos($this->name, '.') === false) {
            $fieldName = $this->lang
                ? sprintf('%s[%s]', $this->lang, $this->name)
                : $this->name;
        } else {
            $nameArr = explode('.', $this->name);
            $first = array_shift($nameArr);
            $last = array_pop($nameArr);

            if ($this->lang) {
                $nameArr[] = $this->lang;
            }
            $nameArr[] = $last;
            $fieldName = sprintf('%s[%s]', $first, implode('][', $nameArr));
        }

        return $fieldName;
    }

    private function getDefaultValue()
    {
        if (strpos($this->name, '.') === false) {
            $default = $this->lang
                ? data_get($this->entity->translate($this->lang), $this->name)
                : data_get($this->entity, $this->name);
        } else {
            $nameArr = explode('.', $this->name);
            $first = array_shift($nameArr);
            $last = array_pop($nameArr);
            $defaultEntity = data_get($this->entity, count($nameArr) ? ($first . '.' . implode('.', $nameArr)) : $first);
            $default = $defaultEntity
                ? ($this->lang
                    ? data_get($defaultEntity->translate($this->lang), $last)
                    : data_get($defaultEntity, $last)
                )
                : null;
        }

        return $default;
    }

    public function type($type)
    {
        $this->type = $type;

        return $this;
    }
}
