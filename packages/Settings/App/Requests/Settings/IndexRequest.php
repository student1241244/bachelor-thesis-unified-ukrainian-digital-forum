<?php
declare( strict_types = 1 );

namespace Packages\Settings\App\Requests\Settings;

use Illuminate\Database\Eloquent\Builder;
use Packages\Dashboard\App\Requests\BaseFilter;
use Packages\Settings\App\Models\Settings;

/**
 * Class IndexRequest
 *
 * @package  App\Modules\Auto
 *
 */
class IndexRequest extends BaseFilter
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return true;
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
                        'user_title',
                        'body',
                    ]),
                ],
                'id' => [
                    'nullable',
                ],
                'user_title' => [
                    'nullable',
                ],
                'body' => [
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
        $query = Settings::query()
            ->selectRaw('
                settings.id,
                settings.user_id,
                users.email AS user_title,
                settings.body
            ')
            ->leftJoin('users', 'users.id', 'settings.user_id')
            ->groupBy('settings.id');

		if ($this->user_title !== null) {
			$query->where("users.email", "like", "%{$this->user_title}%");
		}

		if ($this->body !== null) {
			$query->where("settings.body", "like", "%{$this->body}%");
		}


        return $query;
    }

    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function(Settings $row) {
            return [
                'id' => $row->id,
                'user_title' => strip_tags($row->user_title),
                'body' => strip_tags($row->body),
            ];
        });
    }

}
