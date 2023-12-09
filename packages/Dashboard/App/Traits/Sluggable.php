<?php

namespace Packages\Dashboard\App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sluggable
 *
 * @package Services\Sluggable
 */
trait Sluggable
{
    protected $sluggable = [
        'slug' => 'slug',
        'source' => 'title',
        'priority' => 'slug', // source or slug
        'unique' => true,
        'skipOnUpdate' => false,
        'separator' => '-',
    ];


    public function getSlugableOptions(): array
    {
        $modelOptions = method_exists($this, 'sluggable') ? $this->sluggable(): [];

        return array_merge($this->sluggable, $modelOptions);
    }

    protected static function bootSluggable()
    {
        static::creating(function (Model $model) {
            $model->generateSlugOnCreate();
        });

        static::updating(function (Model $model) {
            $model->generateSlugOnUpdate();
        });
    }

    protected function generateSlugOnCreate()
    {
        $this->addSlug();
    }

    protected function generateSlugOnUpdate()
    {
        if (!$this->getSkipOnUpdate()) {
            $this->addSlug();
        }
    }

    public function getSkipOnUpdate(): bool
    {
        $options = $this->getSlugableOptions();

        if (method_exists($this, 'generateSlugSkipOnUpdate')) {
            return $this->generateSlugSkipOnUpdate();
        } else {
            return $options['skipOnUpdate'];
        }
    }


    protected function addSlug()
    {
        $slug = $this->generateNonUniqueSlug();

        if ($this->getSlugableOptions()['unique']) {
            $slug = $this->makeSlugUnique($slug);
        }

        $this->{$this->getSlugableOptions()['slug']} = $slug;
    }

    /**
     * @return string
     */
    protected function generateNonUniqueSlug(): string
    {
        $slugValue = '';

        $slugField = $this->getSlugableOptions()['slug'];
        $priority = $this->getSlugableOptions()['priority'];
        $slugFromSource = Str::slug($this->getSlugFromSource(), $this->getSlugableOptions()['separator']);

        $slugValue = $priority === 'source'
            ? (!empty($slugFromSource) ? $slugFromSource : $this->$slugField)
            : (!empty($this->$slugField) ? $this->$slugField : $slugFromSource);

        if (empty($slugValue)) {
            $slugValue = Str::random(15);
        }

        return $slugValue;
    }

    protected function getSlugFromSource(): string
    {
        $value = '';
        $source = $this->getSlugableOptions()['source'];
        if (array_key_exists($source, $this->attributes)) {
            $value = $this->$source;
        } else if (!empty($this->relations['translations'])) {
            $translation = $this->relations['translations']->filter(function($item) {
                return $item->locale === app()->getLocale();
            })->first();
            if ($translation) {
                $value = $translation->$source;
            }
        }

        if (empty($value)) {
            $value = Str::random(15);
        }

        return $value;
    }

    protected function makeSlugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $i = 1;

        while ($this->otherRecordExistsWithSlug($slug) || $slug === '') {
            $slug = $originalSlug . $this->getSlugableOptions()['separator'] . $i++;
        }

        return $slug;
    }

    protected function otherRecordExistsWithSlug(string $slug): bool
    {
        $key = $this->getKey();

        $query = static::where($this->getSlugableOptions()['slug'], $slug)
            ->where($this->getKeyName(), '!=', $key)
            ->withoutGlobalScopes();

        if (substr_count(static::class, 'Translation')) {
            $query->where('locale', $this->locale);
        }

        return $query->exists();
    }
}
