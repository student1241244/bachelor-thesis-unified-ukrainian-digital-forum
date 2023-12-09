<?php

namespace Packages\Dashboard\App\Traits;

use I18N;
use Illuminate\Database\Eloquent\Builder;

trait Translatable
{
    use \Astrotomic\Translatable\Translatable;

    public function scopeJoinTranslations(Builder $query)
    {
        $query->leftJoin(
            $this->getTranslationsTable(),
            $this->getTranslationsTable() . '.' . $this->getTranslationRelationKey(),
            '=',
            $this->getTable() . '.' . $this->getKeyName()
        );
        $query->where($this->getTranslationsTable() . '.' . $this->getLocaleKey(), '=', I18N::getCurrentLocale());

        return $query;
    }

    public function scopeJoinTranslationsWithNull(Builder $query)
    {
        $query->leftJoin(
            $this->getTranslationsTable(),
            $this->getTranslationsTable() . '.' . $this->getTranslationRelationKey(),
            '=',
            $this->getTable() . '.' . $this->getKeyName()
        );
        $locale = I18N::getCurrentLocale();
        $localeField = $this->getTranslationsTable() . '.' . $this->getLocaleKey();
        $idField = $this->getTranslationsTable() . '.id';

        $query->whereRaw("({$localeField}='{$locale}' OR {$idField} IS NULL)");

        return $query;
    }

    /**
     * @param string|string $attribute
     * @return array
     */
    public function getListTranslatable(string $attribute = 'title'): array
    {
        return self::query()
            ->selectRaw("
                {$this->table}.id,
                {$this->table}_translation.{$attribute}
            ")
            ->joinTranslationsWithNull()
            ->orderBy($attribute)
            ->get()
            ->pluck($attribute, 'id')->toArray();
    }

}
