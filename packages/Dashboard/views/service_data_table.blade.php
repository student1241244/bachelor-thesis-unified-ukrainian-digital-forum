<?= '<?php'?>

namespace {{ $packageName }}\Services\DataTables;

use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use {{ $packageName }}\Models\{{ $modelName }};
use Packages\Dashboard\App\Services\DataTables\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Packages\Dashboard\App\Traits\RenderHtmlTagsTrait;

class {{ $modelName }}DataTableService extends DataTable
{
    use RenderHtmlTagsTrait;

    /**
     * Get query source of dataTable.
     *
     * @param \{{ $packageName }}\Models\{{ $modelName  }} $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query({{ $modelName }} $model)
    {
        return {!! $query !!}
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

{!! $dataTable !!}
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
{!! $columns !!}
    }

}
