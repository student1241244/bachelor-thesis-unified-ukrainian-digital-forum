<?php
declare( strict_types = 1 );

namespace Packages\Threads\App\Requests\Thread;

use App\Services\ReportService;
use Illuminate\Database\Eloquent\Builder;
use Packages\Dashboard\App\Requests\BaseFilter;
use Packages\Threads\App\Models\Thread;

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
                        'category_title',
                        'title',
                        'body',
                    ]),
                ],
                'id' => [
                    'nullable',
                ],
                'category_title' => [
                    'nullable',
                ],
                'title' => [
                    'nullable',
                ],
                'body' => [
                    'nullable',
                ],
                'reports' => [
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
        $query = Thread::query()
            ->selectRaw('
                threads.id,
                threads.report_data,
                threads.category_id,
                threads_categories.title AS category_title,
                threads.title,
                threads.body
            ')
            ->leftJoin('threads_categories', 'threads_categories.id', 'threads.category_id')
            ->groupBy('threads.id');

		if ($this->category_title !== null) {
			$query->where("threads_categories.title", "like", "%{$this->category_title}%");
		}

		if ($this->title !== null) {
			$query->where("threads.title", "like", "%{$this->title}%");
		}

		if ($this->body !== null) {
			$query->where("threads.body", "like", "%{$this->body}%");
		}

		if ($this->body !== null) {
			$query->where("threads.body", "like", "%{$this->body}%");
		}

		if ($this->reports == '0') {
			$query->where("threads.report_count", "<", ReportService::LIMIT);
		}

		if ($this->reports == '1') {
			$query->where("threads.report_count", ">=", ReportService::LIMIT);
		}


        return $query;
    }

    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function(Thread $row) {

            return [
                'id' => $row->id,
                'category_title' => $row->category_title,
                'image' => $row->getImageOrNull('image', '100x100'),
                'title' => strip_tags('<a href="'.route('threads.threads.edit', $row->id).'">'.$row->title.'</a>'),
                'body' => strip_tags($row->body),
                'reports' => strip_tags((new ReportService)->formatReportData($row)),
            ];
        });
    }

}
