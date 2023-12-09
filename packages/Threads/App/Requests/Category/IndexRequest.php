<?php
declare( strict_types = 1 );

namespace Packages\Threads\App\Requests\Category;

use Illuminate\Database\Eloquent\Builder;
use Packages\Dashboard\App\Requests\BaseFilter;
use Packages\Threads\App\Models\Category;

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
                        'title',
                    ]),
                ],
                'id' => [
                    'nullable',
                ],
                'title' => [
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
        $query = Category::query()
            ->selectRaw('
                threads_categories.id,
                threads_categories.title
            ');
            ->groupBy('threads_categories.id');

		if ($this->title !== null) {
			$query->where("threads_categories.title", "like", "%{$this->title}%");
		}


        return $query;
    }

    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function(Category $row) {
            return [
                'id' => $row->id,
                'title' => '<a href="'.route('threads.categories.edit', $row->id).'">'.$row->title.'</a>',
            ];
        });
    }

}
