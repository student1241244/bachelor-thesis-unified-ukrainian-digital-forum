<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class Form extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'modelName' => $this->getModelName(),
            'formData' => $this->getFormData(),
        ];

        if ($this->hasAction('create') || $this->hasAction('update')) {
            $this->viewToPackageFile('form', $data, 'themes/default/views/' . Str::snake($this->getModelName()) . '/form.blade');
        }
    }

    public function getFormData(): string
    {
        $modelNameSnake = Str::snake($this->getModelName());
        $modelNameVar = Str::camel($this->getModelName());

        $data = '<?php' . self::ENTER;
        $data.= '$action = $'.$modelNameVar.'->id ? route(\''.$this->getPackageNameSnake().'.'.$this->getNameRouteController().'.update\', [$'.$modelNameVar.']) : route(\''.$this->getPackageNameSnake().'.'.$this->getNameRouteController().'.store\');' . self::ENTER;
        $data.= '$labels = trans(\''.$this->getPackageNameSnake().'::'.$modelNameSnake.'.attributes\');' . self::ENTER;

        foreach ($this->getMainFields() as $field) {
            if ($field['type'] === self::FIELD_TYPE_VS_MULTIPLE) {
                $data .= 'if ($'.$modelNameVar.'->'.$field['name'].' instanceof \Illuminate\Database\Eloquent\Collection) {' . self::ENTER;
                $data .= self::TAB1 . '$'.$modelNameVar.'->'.$field['name'].' = $'.$modelNameVar.'->'.$field['name'].'->pluck(\'id\')->toArray();' . self::ENTER;
                $data .= '}' . self::ENTER . self::ENTER;
            }
        }


        $data.= '?>' . self::ENTER;

        $data.= '{!! BootForm::open()' . self::ENTER;
        $data.= self::TAB1 . '->action($action)' . self::ENTER;
        $data.= self::TAB1 . '->multipart()' . self::ENTER;
        $data.= self::TAB1 . '->enctype(\'multipart/form-data\')' . self::ENTER;
        $data.= '!!}' . self::ENTER;

        $data.= self::TAB1 . '{!! BootForm::bind($'.$modelNameVar.') !!}' . self::ENTER;
        $data.= self::TAB1 . '@method($'.$modelNameVar.'->id ? \'PUT\' : \'POST\')' . self::ENTER2;

        if (count($this->getTranslatableFields())) {
            $data.= self::TAB1 . '<div class="tab-content">' . self::ENTER;
            $data.= self::TAB2 . '@foreach(config(\'translatable.locales\') as $locale)' . self::ENTER;
            $data.= self::TAB3 . '<?php $isEmpty = !$'.$modelNameVar.'->translate($locale) ?: false; ?>' . self::ENTER;
            $data.= self::TAB3 . '<div id="tab-{{ $locale }}" class="tab-pane {{$activeTab == $locale ? \'active\' : \'\'}}">' . self::ENTER;

            foreach ($this->getTranslatableFields() as $field) {
                if ($field['type'] === self::FIELD_TYPE_TEXT) {
                    $data .= self::TAB4 . '{!! BootForm::text($labels[\'' . $field['name'] . '\'], $locale . \'[' . $field['name'] . ']\')->defaultValue($isEmpty?null:$' . $modelNameVar . '->translate($locale)->' . $field['name'] . ') !!}' . self::ENTER;
                } elseif ($field['type'] === self::FIELD_TYPE_TEXTAREA) {
                    $data.= self::TAB4 . '{!! BootForm::textarea($labels[\''.$field['name'].'\'], $locale . \'['.$field['name'].']\')->defaultValue($isEmpty?null:$'.$modelNameVar.'->translate($locale)->'.$field['name'].') !!}' . self::ENTER;
                } elseif ($field['type'] === self::FIELD_TYPE_EDITOR) {
                    $data.= self::TAB4 . '{!! BootForm::textarea($labels[\''.$field['name'].'\'], $locale . \'['.$field['name'].']\')->defaultValue($isEmpty?null:$'.$modelNameVar.'->translate($locale)->'.$field['name'].') !!}' . self::ENTER;
                }
            }

            $data.= self::TAB3 . '</div>' . self::ENTER;
            $data.= self::TAB2 . '@endforeach' . self::ENTER;
            $data.= self::TAB1 . '</div>' . self::ENTER2;
        }

        foreach ($this->getMainFields() as $field) {
            if (!array_get($field, 'editable', true)) {
                continue;
            }

            if (in_array($field['type'], [self::FIELD_TYPE_TEXT, self::FIELD_TYPE_INTEGER, self::FIELD_TYPE_DOUBLE])) {
                $data.= self::TAB1 . '{!! BootForm::text($labels[\''.$field['name'].'\'], \''.$field['name'].'\') !!}' . self::ENTER;
            } elseif ($field['type'] === self::FIELD_TYPE_TEXTAREA) {
                $data.= self::TAB1 . '{!! BootForm::textarea($labels[\''.$field['name'].'\'], \''.$field['name'].'\') !!}' . self::ENTER;
            } elseif ($field['type'] === self::FIELD_TYPE_TIMESTAMP) {
                $data.= self::TAB1 . '{!! BootForm::text($labels[\''.$field['name'].'\'], \''.$field['name'].'\') !!}' . self::ENTER;
            } elseif ($field['type'] === self::FIELD_TYPE_EDITOR) {
                $data.= self::TAB1 . '{!! BootForm::textarea($labels[\''.$field['name'].'\'], \''.$field['name'].'\') !!}' . self::ENTER;
            } elseif ($field['type'] === self::FIELD_TYPE_FOREIGN) {
                $data.= self::TAB1 . '{!! BootForm::select($labels[\''.$field['name'].'\'], \''.$field['name'].'\', '.$field['relation']['class'].'::getList())->class(\'select2\') !!}' . self::ENTER;
            } elseif ($field['type'] === self::FIELD_TYPE_VS_MULTIPLE) {
                $data.= self::TAB1 . '{!! BootForm::select($labels[\''.$field['name'].'\'], \''.$field['name'].'\', '.$field['relation']['class'].'::getList())->class(\'select2\')->multiple() !!}' . self::ENTER;
            } elseif ($field['type'] === self::FIELD_TYPE_BOOLEAN) {
                $data.= self::TAB1 . '{!! BootForm::select($labels[\''.$field['name'].'\'], \''.$field['name'].'\', \Packages\Dashboard\App\Helpers\CrudHelper::getYesNoList()) !!}' . self::ENTER;
            } elseif ($field['type'] === self::FIELD_TYPE_CHECKBOX) {
                $data.= self::TAB1 . '{!! BootForm::select($labels[\''.$field['name'].'\'], \''.$field['name'].'\', \Packages\Dashboard\App\Helpers\CrudHelper::getYesNoList()) !!}' . self::ENTER;
            } elseif ($field['type'] === self::FIELD_TYPE_IMAGE) {

                $data.= self::ENTER;
                $data.= self::TAB1 . '@include(\'tpx_dashboard::dashboard.partials._file-upload\', [' . self::ENTER;
                $data.= self::TAB2 . '\'model\' => $'.$modelNameVar.',' . self::ENTER;
                $data.= self::TAB2 . '\'name\' => \''.$field['name'].'\',' . self::ENTER;
                $data.= self::TAB2 . '\'label\' => $labels[\''.$field['name'].'\'],' . self::ENTER;
                $data.= self::TAB2 . '\'accept\' => \'image/*\',' . self::ENTER;
                $data.= self::TAB1 . '])' . self::ENTER2;
            }
        }

        $data.= self::ENTER . self::TAB1 . '{!! BootForm::reset(\'<i class="fa fa-undo fa-fw"></i> \' . trans(\'dashboard::dashboard.reset\'))->class(\'btn btn-sm btn-default\') !!}' . self::ENTER;
        $data.= self::TAB1 . '{!! BootForm::submit(\'<i class="fa fa-save fa-fw"></i> \' . trans(\'dashboard::dashboard.save\'))->class(\'btn btn-sm btn-success\') !!}' . self::ENTER;

        $data.= self::ENTER . '{!! BootForm::close() !!}' . self::ENTER;


        return $data;
    }
}
