<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class Routes extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'routes' => $this->getRoutes(),
        ];

        $this->viewToPackageFile('routes', $data, 'App/routes', [
            'prefixContent' => "<?php\n",
        ]);
    }

    public function getRoutes(): string
    {
        $data = '';

        foreach ($this->getModelsConfig() as $modelName => $modelConfig) {
            $crud = array_get($modelConfig, 'crud', true);
            $vs = array_get($modelConfig, 'vs', false);

            if (!$crud || $vs) {
                continue;
            }

            $exceptActions = [];
            foreach ($modelConfig['actions'] as $action => $is) {
                if (!$is) {
                    $exceptActions[] = $action;
                    if ($action === 'update') {
                        $exceptActions[] = 'edit';
                    }
                    if ($action === 'create') {
                        $exceptActions[] = 'store';
                    }
                }
            }

            if ($modelConfig['name_plural'] !== $modelConfig['name_singular']) {

                if (count($exceptActions)) {
                    $exceptActionsWithQuote = array_map(function ($value) {
                        return "'$value'";
                    }, $exceptActions);

                    $data .= self::TAB2 . 'Route::resource(\'' . $modelConfig['routePathController'] . '\', \'' . $modelName . 'Controller\', [\'except\' => [' . implode(', ', $exceptActionsWithQuote) . ']]);' . self::ENTER;
                } else {
                    $data .= self::TAB2 . 'Route::resource(\'' . $modelConfig['routePathController'] . '\', \'' . $modelName . 'Controller\');' . self::ENTER;
                }
            } else {
                $data .= self::TAB2 . 'Route::get(\'' . $modelConfig['routePathController'] . '\', \'' . $modelName . 'Controller@index\')->name(\''.Str::snake($modelConfig['name_singular']).'.index\');' . self::ENTER;
                $data .= self::TAB2 . 'Route::get(\'' . $modelConfig['routePathController'] . '/create\', \'' . $modelName . 'Controller@create\')->name(\''.Str::snake($modelConfig['name_singular']).'.create\');' . self::ENTER;
                $data .= self::TAB2 . 'Route::post(\'' . $modelConfig['routePathController'] . '\', \'' . $modelName . 'Controller@store\')->name(\''.Str::snake($modelConfig['name_singular']).'.store\');' . self::ENTER;
                $data .= self::TAB2 . 'Route::get(\'' . $modelConfig['routePathController'] . '/{'.Str::camel($modelConfig['name_singular']).'}/edit\', \'' . $modelName . 'Controller@edit\')->name(\''.Str::snake($modelConfig['name_singular']).'.edit\');' . self::ENTER;
                $data .= self::TAB2 . 'Route::put(\'' . $modelConfig['routePathController'] . '/{'.Str::camel($modelConfig['name_singular']).'}\', \'' . $modelName . 'Controller@update\')->name(\''.Str::snake($modelConfig['name_singular']).'.update\');' . self::ENTER;
                $data .= self::TAB2 . 'Route::delete(\'' . $modelConfig['routePathController'] . '/{'.Str::camel($modelConfig['name_singular']).'}\', \'' . $modelName . 'Controller@destroy\')->name(\''.Str::snake($modelConfig['name_singular']).'.destroy\');' . self::ENTER;
            }

            $data .= "\n";
        }

        return $data;
    }
}
