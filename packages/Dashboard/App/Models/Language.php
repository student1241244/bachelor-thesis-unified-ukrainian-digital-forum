<?php

namespace Packages\Dashboard\App\Models;

use Illuminate\Database\Eloquent\Model;
use Matrix\Exception;

class Language extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'code',
    ];

    /**
     * @return array
     */
    public static function getList(): array
    {
        return [
            'ua' => 'UA',
        ];

        try {
            $list = self::query()->pluck('title', 'code')->toArray();
            foreach ($list as $code => $title)  {
                $list[$code] = $title;
            }

            return !empty($list) ? $list : self::getListDefault();
        } catch (\Exception $e) {
            return self::getListDefault();
        }
    }

    /**
     * @return array
     */
    public static function getListDefault(): array
    {
        $supportedLocales = config('laravellocalization.supportedLocales');
        $defaultLocale = config('app.locale');
        $localeName = array_get($supportedLocales, $defaultLocale . '.name', strtoupper($defaultLocale));

        return [$defaultLocale => $localeName];
    }

    /**
     * @return array
     */
    public static function getSupportedLocales(): array
    {
        $data = [];

        foreach (self::getList() as $code => $title)  {
            $data[$code] = [
                'name' => $title,
                'script' => 'Cyrl',
                'native' => $title,
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    public static function getLocales(): array
    {
        return array_keys(self::getList());
    }

}
