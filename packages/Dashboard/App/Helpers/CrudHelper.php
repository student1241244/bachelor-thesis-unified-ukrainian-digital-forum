<?php


namespace Packages\Dashboard\App\Helpers;


class CrudHelper
{
    /**
     * @return string[]
     */
    public static function getYesNoList(): array
    {
        return [trans('dashboard::dashboard.no'), trans('dashboard::dashboard.yes')];
    }
}
