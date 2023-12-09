<?php

namespace Packages\Dashboard\App\Services\DataTables;

use Illuminate\Support\Str;
use Yajra\DataTables\Services\DataTable as BaseDataTable;

/**
 * Class DataTable
 * @package Packages\Dashboard\App\Services\DataTables
 */
abstract class DataTable extends BaseDataTable
{
    const ACTIONS_DROPDOWN = 'dropdown';

    /**
     * @var string[]
     */
    public static $defaultActions = ['edit', 'destroy'];

    /**
     * @var int
     */
    protected $pageLength = 50;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var array
     */
    protected $order;

    /**
     * @var bool
     */
    public $withCheckboxes = false;

    /**
     * DataTable constructor.
     */
    public function __construct()
    {
        $this->_initCheckboxes();
    }

    /**
     * @param string $value
     */
    public function setModel(string $value)
    {
        $this->model = $value;
    }

    /**
     * @param bool $plural
     * @return string
     */
    public function getModel(bool $plural = true): string
    {
        return !is_null($this->model)
            ? $this->model
            : Str::snake($plural ? Str::plural(request()->modelName) : request()->modelName);
    }

    /**
     * @return string
     */
    public function getPackage(): string
    {
        return Str::snake(request()->packageName);
    }

    /**
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->_buildColumns())
            ->minifiedAjax()
            ->parameters([
                'pageLength' => $this->pageLength,
                'language' => [
                    'url' => url('vendor/dashboard/js/data-tables/languages/' . app()->getLocale() . '.json'),
                ],
                'order'    => $this->_getOrder(),
            ]);
    }

    /**
     * Init options and scripts for checkboxes column
     *
     * For scripts options see https://www.gyrocode.com/projects/jquery-datatables-checkboxes/
     */
    protected function _initCheckboxes(): void
    {
        $dt = $this;

        $this->builder()->macro('withCheckboxes',
            function () use ($dt) {
                return $dt->withCheckboxes;
            });

        $this->builder()->macro('checkboxesScripts',
            function () use ($dt) {
                return $dt->getCheckboxScripts();
            });
    }

    /**
     * Build columns
     *
     * @return array
     */
    protected function _buildColumns(): array
    {
        $columns = $this->getColumns();

        if ($this->withCheckboxes) {
            array_unshift($columns, $this->_getCheckboxField());
        }

        return $columns;
    }

    /**
     * Get columns definitions.
     *
     * @return array
     */
    abstract protected function getColumns();

    /**
     * @param string|int $fieldName field name or number
     * @param string $direction
     */
    public function orderBy($fieldName, $direction = 'asc'): void
    {
        $this->order = [$fieldName, $direction];
    }

    /**
     * @return array[]
     */
    protected function _getOrder()
    {
        if (isset($this->order) && count($this->order)) {
            $orders = !is_array($this->order[0])
                ? [$this->order]
                : $this->order;

            $dataOrdering = [];

            foreach ($orders as $order) {

                $fieldNumber = is_int($order[0])
                    ? $order[0]
                    : collect($this->getColumns())->pluck('data')->search($order[0]);

                $direction = $order[1];
                $dataOrdering[] = [$fieldNumber, $direction];
            }
            return $dataOrdering;

        } else {
            $fieldNumber = 0;
            $direction = 'asc';
        }

        if ($this->withCheckboxes) {
            ++$fieldNumber;
        }

        return [[$fieldNumber, $direction]];

    }

    /**
     * @return array
     */
    protected function _getCheckboxField(): array
    {
        return [
            'data'       => 'id',
            'title'      => '',
            'checkboxes' => [
                'selectAllRender'   => $this->_getCheckboxSelectAllMarkup(),
                'selectCallback'    => $this->_getCheckboxCallback(),
                'selectAllCallback' => $this->_getCheckboxAllCallback(),
            ],
            'width'      => '20px',
            'orderable'  => false,
            'searchable' => false,
            'exportable' => false,
            'printable'  => false,
            'className'  => 'dt-nowrap',
        ];
    }

    /**
     * @return string
     */
    public function getCheckboxScripts(): string
    {
        return '';
    }

    /**
     * @return string
     */
    protected function _getCheckboxSelectAllMarkup(): string
    {
        return '<input type="checkbox">';
    }

    /**
     * @return string|null
     */
    protected function _getCheckboxCallback()
    {
        return null;
    }

    /**
     * @return string|null
     */
    protected function _getCheckboxAllCallback()
    {
        return null;
    }

    /**
     * @param string $attribute
     * @return string|null
     */
    public function getColumnTitle(string $attribute):? string
    {
        $labels = trans($this->getPackage() . '::' . $this->getModel(false) . '.attributes');
        return array_get($labels, $attribute, ucfirst($attribute));
    }

    /**
     * @param array $columns
     * @return array
     */
    public function setColumnTitles(array $columns): array
    {
        foreach ($columns as & $column) {
            if ($column['data'] === 'id' && !isset($column['width'])) {
                $column['width'] = 50;
            }

            if (!isset($column['title'])) {
                $column['title'] = $this->getColumnTitle($column['data']);
            }

            if ($column['data'] === 'actions') {
                $actionsdefaultConfig = [
                    'width' => '150px',
                    'orderable'  => false,
                    'searchable' => false,
                    'className'  => 'dt-nowrap text-right',
                ];
                foreach ($actionsdefaultConfig as $key => $value) {
                    if (!isset($column[$key])) {
                        $column[$key] = $value;
                    }
                }
            }
        }

        return $columns;
    }

}
