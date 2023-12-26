<?php
declare( strict_types = 1 );

namespace Packages\Questions\App\Requests\Question;

use App\Models\Question;
use App\Services\ReportService;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Packages\Dashboard\App\Requests\BaseFilter;

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
                        'title',
                        'body',
                    ]),
                ],
                'id' => [
                    'nullable',
                ],
                'user_title' => [
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
        $query = Question::query()
            ->selectRaw('
                questions.id,
                questions.report_data,
                questions.user_id,
                users.email AS user_title,
                questions.title,
                questions.body
            ')
            ->leftJoin('users', 'users.id', 'questions.user_id')
            ->groupBy('questions.id');

		if ($this->user_title !== null) {
			$query->where("users.email", "like", "%{$this->user_title}%");
		}

		if ($this->title !== null) {
			$query->where("questions.title", "like", "%{$this->title}%");
		}

		if ($this->body !== null) {
			$query->where("questions.body", "like", "%{$this->body}%");
		}

        if ($this->reports == '0') {
            $query->where("questions.report_count", "<", ReportService::LIMIT);
        }

        if ($this->reports == '1') {
            $query->where("questions.report_count", ">=", ReportService::LIMIT);
        }

        return $query;
    }

    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function(Question $row) {
            $images = '';
            foreach ($row->getMedia('images') as $img) {
                $images .=  '<a style="padding-right: 3px;" href="'.$img->getUrl().'" target="_blank"><img height="20" src="'.$img->getUrl().'"></a>';
            }

            return [
                'id' => $row->id,
                'user_title' => strip_tags($row->user_title),
                'images' => $images,
                'title' => strip_tags('<a href="'.route('questions.questions.edit', $row->id).'">'.$row->title.'</a>'),
                'body' => strip_tags($row->body),
                'reports' => strip_tags((new ReportService)->formatReportData($row)),
            ];
        });
    }

}
