<?php

use Packages\Dashboard\App\Form\Field;
use Illuminate\Support\Str;

if (!function_exists('can')) {
    function can(string $permission)
    {
        return (new \Packages\Dashboard\App\Services\Permission\PermissionService())->can($permission);
    }
}

if (!function_exists('getMediaUrl')) {
    /**
     * This function works with spatie laravel-medialibrary.
     * It checks whether image exists or not and returns requested image or default image placeholder
     *
     * @param $model
     * @param string $collection If you want to force return image placeholder use "_default"
     * @param string $conversion
     * @return string
     */
    function getMediaUrl($model, $collection = '', $conversion = '')
    {
        $fileName = $conversion ?? 'default-publication-pic';

        $placeholdersUrl = config('tpx_dashboard.placeholders-url');
        $modelFolderFilename = $placeholdersUrl .Str::snake(class_basename($model)) .  '/' .  $fileName . '.jpg';

        $defaultImage = is_file(public_path() . $modelFolderFilename)
            ? $modelFolderFilename
            : $placeholdersUrl . $fileName . '.jpg';

        if (method_exists($model, 'collection') && $model->collection()) {
            $collection = $collection ?? $model->collection();
        }

        if ($collection == '_default') {
            return $defaultImage;
        }

        $image = $model->getFirstMediaUrl($collection, $conversion);

        if (!$image) {
            return $defaultImage;
        }

        $isConverted = $conversion ? $model->getFirstMedia($collection)
            ->hasGeneratedConversion($conversion) : true;

        return $isConverted ? $image : $defaultImage;
    }
}

if (!function_exists('getFileUrl')) {
    /**
     * This function works with spatie laravel-medialibrary.
     * It checks whether image exists or not and returns requested image or default image placeholder
     *
     * @param $model
     * @param string $collection If you want to force return image placeholder use "_default"
     * @param string $conversion
     * @return string
     */
    function getFileUrl($model, $collection = '', $conversion = '')
    {
        $placeholdersUrl = config('tpx_dashboard.placeholders-url');

        $fileIcon = $placeholdersUrl .'file.png';
        $emptyFileIcon = $placeholdersUrl . 'empty-file.png';

        if (method_exists($model, 'collection') && $model->collection()) {
            $collection = $collection ?? $model->collection();
        }

        if ($collection == '_default') {
            return $emptyFileIcon;
        }

        $file = $model->getFirstMediaUrl($collection);

        return !$file ? $emptyFileIcon : $fileIcon;
    }
}

if (!function_exists('tel_link')) {
    function tel_link($number)
    {
        return preg_replace('/[^\d\+]/', '', $number);
    }
}

if (!function_exists('input')) {
    function input($entity, $label, $name)
    {
        return Field::input($entity, $label, $name)->render();
    }
}
if (!function_exists('trans_input')) {
    function trans_input($entity, $label, $lang, $name)
    {
        return Field::input($entity, $label, $name)->translated($lang)->render();
    }
}
if (!function_exists('trans_textarea')) {
    function trans_textarea($entity, $label, $lang, $name)
    {
        return Field::input($entity, $label, $name)
            ->type('textarea')
            ->translated($lang)
            ->render();
    }
}
if (!function_exists('trans_redactor')) {
    function trans_redactor($entity, $label, $lang, $name)
    {
        return trans_textarea($entity, $label, $lang, $name)->data('redactor-input-full', true);
    }
}
if (!function_exists('trans_redactor_min')) {
    function trans_redactor_min($entity, $label, $lang, $name)
    {
        return trans_textarea($entity, $label, $lang, $name)->data('redactor-input-min', true);
    }
}
if (!function_exists('blank_string')) {
    function blank_string($value)
    {
        return blank($value) || blank(trim(strip_tags($value)));
    }
}
if (!function_exists('blank_strings_array')) {
    function blank_strings_array($values)
    {
        return blank($values) || blank(array_filter($values, function ($val) {
                    return !blank_string($val);
                }));
    }
}

if (!function_exists('rm_dir_recursive')) {
    function rm_dir_recursive($path) {
        if (is_file($path)) return unlink($path);
        if (is_dir($path)) {
            foreach(scandir($path) as $p) if (($p!='.') && ($p!='..'))
                rm_dir_recursive($path.DIRECTORY_SEPARATOR.$p);
            return rmdir($path);
        }
        return false;
    }
}

if (!function_exists('required_mark')) {
    function required_mark(string $label)
    {
        return $label . ' <span style="color: #ED5565;">*</span>';
    }
}

if (!function_exists('optional_mark')) {
    function optional_mark(string $label)
    {
        return $label . ' <span style="color: #999;"> ('.trans('dashboard::dashboard.optional').')</span>';
    }
}


