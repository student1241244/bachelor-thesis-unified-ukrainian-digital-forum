<?php
echo '<?php';
?>

declare( strict_types = 1 );

namespace Packages\{{ $packageName }}\App\Requests\{{ $modelName }};

use Illuminate\Database\Eloquent\Builder;
use Packages\Dashboard\App\Requests\BaseFilter;
use Packages\{{ $packageName }}\App\Models\{{ $modelName }};

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
@foreach($sortableFields as $f)
                        '{{ $f }}',
@endforeach
                    ]),
                ],
@foreach($filterableFields as $f)
                '{{ $f }}' => [
                    'nullable',
                ],
@endforeach
            ];

        return $rules;
    }

    /*
     * @return  Builder
     */
    public function getQueryBuilder() : Builder
    {
        $query = {{ $modelName }}::query()
            ->selectRaw('
@foreach($selectAttributes as $a)
                {!! $a !!}{{ $loop->last ? '':',' }}
@endforeach
            '){{ count($translatableAttributes) ? '':';' }}
@foreach($extraWhere as $v)
            {!! $v !!}
@endforeach
@if ($translatableAttributes)
            ->joinTranslations()
@endif
@foreach ($leftJoins as $item)
            {!! $item !!}
@endforeach
            ->groupBy('{{ $tableName }}.id');

{!! $filterConditions !!}
        return $query;
    }

    /*
     * @return  array
     */
    public function getData()
    {
        return $this->resolveData(function({{ $modelName }} $row) {
            return [
                'id' => $row->id,
@foreach($indexFields as $k => $val)
                '{{ $k }}' => {!! $val !!},
@endforeach
            ];
        });
    }

}
