<?php
declare( strict_types = 1 );

namespace Packages\Questions\App\Requests\Comment;

use App\Services\ReportService;
use Illuminate\Database\Eloquent\Builder;
use Packages\Dashboard\App\Requests\BaseFilter;
use App\Models\Comment;

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
                        'question_title',
                        'user_title',
                        'body',
                    ]),
                ],
                'id' => [
                    'nullable',
                ],
                'question_title' => [
                    'nullable',
                ],
                'user_title' => [
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
                comments.id,
                comments.report_data,
                comments.question_id,
                questions.title AS question_title,
                comments.user_id,
                users.email AS user_title,
                comments.body
            ')
            ->leftJoin('users', 'users.id', 'comments.user_id')
            ->leftJoin('questions', 'questions.id', 'comments.question_id')
            ->groupBy('comments.id');

		if ($this->question_title !== null) {
			$query->where("questions.title", "like", "%{$this->question_title}%");
		}

		if ($this->user_title !== null) {
			$query->where("users.email", "like", "%{$this->user_title}%");
		}

		if ($this->body !== null) {
			$query->where("comments.body", "like", "%{$this->body}%");
		}

        if ($this->reports == '0') {
            $query->where("comments.report_count", "<", ReportService::LIMIT);
        }

        if ($this->reports == '1') {
            $query->where("comments.report_count", ">=", ReportService::LIMIT);
        }

        return $query;
    }

    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function(Comment $row) {
            $images = '';
            foreach ($row->getMedia('images') as $img) {
                $images .=  '<a style="padding-right: 3px;" href="'.$img->getUrl().'" target="_blank"><img height="20" src="'.$img->getUrl('100x100').'"></a>';
            }

            return [
                'id' => $row->id,
                'question_title' => $row->question_title,
                'user_title' => $row->user_title,
                'body' => $row->body,
                'images' => $images,
                'reports' => (new ReportService)->formatReportData($row),
            ];
        });
    }

}
