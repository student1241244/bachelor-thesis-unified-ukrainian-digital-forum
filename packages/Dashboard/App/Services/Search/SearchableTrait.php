<?php

namespace Packages\Dashboard\App\Services\Search;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait SearchableTrait
 * @package Packages\Dashboard\App\Services\Search
 */
trait SearchableTrait
{
    /**
     * @param Builder $query
     * @param string $q
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $q): Builder
    {
        if ($this->isTranslated()) {
            $query->joinTranslationsWithNull();
        }

        $conditions = [];
        foreach ($this->resolveSearchableAttributes() as $attr) {
            $conditions[] = "$attr LIKE '%{$q}%'";
        }
        $query->whereRaw("(".implode(' OR ', $conditions).")");

        return $query;
    }

    /**
     * @return bool
     */
    public function isTranslated(): bool
    {
        return property_exists($this, 'translatedAttributes');
    }

    /**
     * @return array
     */
    public function resolveSearchableAttributes(): array
    {
        $translatableAttributes = [];
        if ($this->isTranslated()) {
            $translatableAttributes = $this->translatedAttributes;
        }

        $table = $this->getTable();
        $tableTrans = $table . '_translation';
        $attributes = [];
        foreach ($this->searchableAttributes() as $attr) {
            $attributes[] = in_array($attr, $translatableAttributes)
                ? $tableTrans . '.' . $attr
                : $table . '.' . $attr;
        }

        return $attributes;
    }
}
