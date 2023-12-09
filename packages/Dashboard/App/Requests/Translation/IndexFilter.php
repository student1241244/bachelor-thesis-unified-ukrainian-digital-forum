<?php

declare( strict_types = 1 );

namespace Packages\Dashboard\App\Requests\Translation;

use Illuminate\Database\Eloquent\Builder;
use Packages\Dashboard\App\Models\Translation;
use Packages\Dashboard\App\Requests\BaseFilter;
use Packages\Dashboard\App\Models\User;

/**
 * Class IndexRequest
 *
 * @package  App\Modules\Auto
 *
 */
class IndexFilter extends BaseFilter
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return true;
        //return can('');
    }

    /*
     * @return  array
     */
    public function rules(): array
    {
        $rules = parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'id',
                    'group',
                    'key',
                ]),
            ],
            'group' => [
                'nullable',
            ],
            'key' => [
                'nullable',
            ],
            'text' => [
                'nullable',
            ],
        ];

        return $rules;
    }

    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = Translation::query();

        if ($this->id !== null) {
            $query->where("id", "like", "%{$this->id}%");
        }

        if ($this->group !== null) {
            $query->where("group", "like", "%{$this->group}%");
        }

        if ($this->key !== null) {
            $query->where("key", "like", "%{$this->key}%");
        }

        if ($this->text !== null) {
            $query->where("text", "like", "%{$this->text}%");
        }

        return $query;
    }

    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function(Translation $row) {
            return [
                'id' => $row->id,
                'group' => $row->group,
                'key' => $row->key,
                'text' => array_get($row->text, app()->getLocale()),
            ];
        });
    }

}
