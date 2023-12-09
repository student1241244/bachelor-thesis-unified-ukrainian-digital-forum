<?php

namespace Packages\Dashboard\App\Services\DataTables;

use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Packages\Dashboard\App\Models\Language;
use Packages\Dashboard\App\Services\DataTables\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Packages\Dashboard\App\Traits\RenderHtmlTagsTrait;

class LanguageDataTableService extends DataTable
{
    use RenderHtmlTagsTrait;

    /**
     * Get query source of dataTable.
     *
     * @param \Packages\Dashboard\App\Models\Language $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Language $model)
    {
        return $model::query();

    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('title', function (Language $language) {
                return can('dashboard.languages.update')
                    ? '<a href="' . route('dashboard.languages.edit', $language) . '">' .$language->title. '</a>'
                    : $language->title;
            })
            ->addColumn('code', function ($language) {
                return can('dashboard.languages.update')
                    ? '<a href="' . route('dashboard.languages.edit', $language) . '">' .$language->code. '</a>'
                    : $language->code;
            })
            ->addColumn('actions', function ($language) {
                return $this->renderActions($language);
            })
            ->orderColumn('code', 'code $1')
            ->orderColumn('title', 'title $1')
            ->filterColumn('code', function ($query, $keyword) {
                $query->when($keyword, function ($query, $keyword) {
                    return $query->whereRaw("code LIKE '%$keyword%'");
                });
            })
            ->filterColumn('title', function ($query, $keyword) {
                $query->when($keyword, function ($query, $keyword) {
                    return $query->whereRaw("title LIKE '%$keyword%'");
                });
            })
            ->rawColumns(['actions', 'title', 'code']);
   }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return $this->setColumnTitles([
            [
                'data' => 'id',
                'title' => '#',
            ],
            [
                'data' => 'title',
            ],
            [
                'data' => 'code',
            ],
            [
                'data'  => 'actions',
                'title' => trans('dashboard::dashboard.actions'),
                'width' => '150px',
                'orderable'  => false,
                'searchable' => false,
                'className'  => 'dt-nowrap text-right',
            ]
        ]);
    }

}
