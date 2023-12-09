<?php

namespace Packages\Dashboard\App\Services\DataTables;

use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Packages\Dashboard\App\Models\Role;
use Packages\Dashboard\App\Services\DataTables\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Packages\Dashboard\App\Traits\RenderHtmlTagsTrait;

class RoleDataTableService extends DataTable
{
    use RenderHtmlTagsTrait;

    /**
     * Get query source of dataTable.
     *
     * @param \Packages\Dashboard\App\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
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
            ->addColumn('title', function (Role $role) {
                return '<a href="' . route('dashboard.roles.edit', $role) . '">' .$role->title. '</a>';
            })
            ->addColumn('slug', function ($role) {
                return '<a href="' . route('dashboard.roles.edit', $role) . '">' .$role->slug. '</a>';
            })
            ->addColumn('actions', function ($role) {
                return $this->renderActions($role);
            })
            ->orderColumn('slug', 'slug $1')
            ->orderColumn('title', 'title $1')
            ->filterColumn('slug', function ($query, $keyword) {
                $query->when($keyword, function ($query, $keyword) {
                    return $query->whereRaw("slug LIKE '%$keyword%'");
                });
            })
            ->filterColumn('title', function ($query, $keyword) {
                $query->when($keyword, function ($query, $keyword) {
                    return $query->whereRaw("title LIKE '%$keyword%'");
                });
            })
            ->rawColumns(['actions', 'title', 'slug']);
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
                'data' => 'slug',
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
