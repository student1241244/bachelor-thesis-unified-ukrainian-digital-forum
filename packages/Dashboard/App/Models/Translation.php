<?php

/**
 * @package     Translations
 * @version     0.1.0
 * @author      LLC <contact@test-llc.com>
 * @license     MIT
 * @copyright   2017, LLC
 * @link        http://test-llc.com
 */
namespace Packages\Dashboard\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Packages\Dashboard\App\Services\Search\SearchableContract;
use Packages\Dashboard\App\Services\Search\SearchableTrait;

class Translation extends Model implements SearchableContract
{
    use SearchableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'language_lines';

    /**
     * @var array
     */
    protected $fillable = [
        'group',
        'key',
        'text',
        'note',
    ];

    /** @var array */
    public $translatable = ['text'];

    /** @var array */
    public $guarded = ['id'];

    /** @var array */
    protected $casts = ['text' => 'array'];

    public static function boot()
    {
        parent::boot();

        $flushGroupCache = function (self $languageLine) {
            $languageLine->flushGroupCache();
        };

        static::saved($flushGroupCache);
        static::deleted($flushGroupCache);
    }

    public static function getTranslationsForGroup(string $locale, string $group): array
    {
        return Cache::rememberForever(static::getCacheKey($group, $locale), function () use ($group, $locale) {
            return static::query()
                    ->where('group', $group)
                    ->get()
                    ->reduce(function ($lines, self $languageLine) use ($locale) {
                        $translation = $languageLine->getTranslation($locale);
                        if ($translation !== null) {
                            Arr::set($lines, $languageLine->key, $translation);
                        }

                        return $lines;
                    }) ?? [];
        });
    }

    public static function getCacheKey(string $group, string $locale): string
    {
        return "spatie.translation-loader.{$group}.{$locale}";
    }

    /**
     * @param string $locale
     */
    public function getTranslation(string $locale)
    {
        if (! isset($this->text[$locale])) {
            $fallback = config('app.fallback_locale');

            return $this->text[$fallback] ?? null;
        }

        return $this->text[$locale];
    }

    /**
     * @param string $locale
     * @param string $value
     *
     * @return $this
     */
    public function setTranslation(string $locale, string $value)
    {
        $this->text = array_merge($this->text ?? [], [$locale => $value]);

        return $this;
    }

    public function flushGroupCache()
    {
        foreach ($this->getTranslatedLocales() as $locale) {
            Cache::forget(static::getCacheKey($this->group, $locale));
        }
    }

    protected function getTranslatedLocales(): array
    {
        return array_keys($this->text);
    }

    /**
     * @return array
     */
    public function searchableAttributes(): array
    {
        return ['key', 'text', 'note'];
    }

}
