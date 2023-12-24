<?php

namespace Packages\Dashboard\App\Services\Base;

use Yajra\DataTables\EloquentDataTable as BaseEloquentDataTable;
use Illuminate\Database\Eloquent\Builder;
use DB;

class EloquentDataTable extends BaseEloquentDataTable
{
    /**
     * @return int
     */
    public function count(): int
    {
        $queryBuilder = $this->prepareCountQuery();
        $sql = self::sql($queryBuilder);
        $sql = explode('limit', $sql)[0];

        $row = DB::select("SELECT COUNT(*) AS `count` FROM ({$sql}) AS r");

        $count = isset($row[0]) ? $row[0]->count : 0;

        return $count;

    }

    /**
     * @param Builder $queryBuilder
     * @return string
     */
    public static function sql(Builder $queryBuilder) : string
    {
        $sql = str_replace('?', '%s', $queryBuilder->toSql());

        $handledBindings = array_map(function ($binding) {
            if (is_numeric($binding)) {
                return $binding;
            }

            if (is_bool($binding)) {
                return ($binding) ? 'true' : 'false';
            }

            return "'{$binding}'";
        }, $queryBuilder->getBindings());

        info($sql);

        return vsprintf($sql, $handledBindings);
    }

}
