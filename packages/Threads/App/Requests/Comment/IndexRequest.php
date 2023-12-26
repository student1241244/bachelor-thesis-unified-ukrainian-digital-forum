<?php
declare( strict_types = 1 );

namespace Packages\Threads\App\Requests\Comment;

use App\Services\ReportService;
use Illuminate\Database\Eloquent\Builder;
use Packages\Dashboard\App\Requests\BaseFilter;
use Packages\Threads\App\Models\Comment;

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
                        'thread_title',
                        'body',
                    ]),
                ],
                'id' => [
                    'nullable',
                ],
                'thread_title' => [
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
        $query = Comment::query()
            ->selectRaw('
                threads_comments.id,
                threads_comments.report_data,
                threads_comments.thread_id,
                threads.title AS thread_title,
                threads_comments.body
            ')
            ->leftJoin('threads', 'threads.id', 'threads_comments.thread_id')
            ->groupBy('threads_comments.id');

		if ($this->thread_title !== null) {
			$query->where("threads.title", "like", "%{$this->thread_title}%");
		}

		if ($this->body !== null) {
			$query->where("threads_comments.body", "like", "%{$this->body}%");
		}

        if ($this->reports == '0') {
            $query->where("threads_comments.report_count", "<", ReportService::LIMIT);
        }

        if ($this->reports == '1') {
            $query->where("threads_comments.report_count", ">=", ReportService::LIMIT);
        }


        return $query;
    }

    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function(Comment $row) {
            return [
                'id' => $row->id,
                'thread_title' => strip_tags($row->thread_title),
                'body' => strip_tags($row->body),
                'reports' => strip_tags((new ReportService)->formatReportData($row)),
            ];
        });
    }

}
