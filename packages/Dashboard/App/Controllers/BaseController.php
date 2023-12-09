<?php

namespace Packages\Dashboard\App\Controllers;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Packages\Dashboard\App\Models\User;
use Illuminate\Routing\Controller;
use Packages\Dashboard\App\Services\Counters\CountersService;
use Packages\Dashboard\App\Traits\HasJsTrait;

class BaseController extends Controller
{
    use HasJsTrait;

    /**
     * BaseController constructor.
     * @param array $except
     */
    public function __construct(array $except = [])
    {
        $this->middleware('dashboardAuth', ['except' => $except]);
        $this->middleware('packageModelDetect');

        if(config('translatable.is_enabled')) {
            $this->middleware('localeSessionRedirect');
            $this->middleware('localizationRedirect');
            $this->middleware('localeViewPath');
        }
    }

    /**
     * @param $model
     * @return array
     */
    protected function locCfg ($model): array
    {
        $locCfg = config('translatable');

        $locCfg['is_enabled'] = $model->translatedAttributes;

        return $locCfg;
    }

    /**
     * @param string $action
     * @return string
     */
    public function getSuccessMessage(string $action): string
    {
        return trans(Str::snake(request()->packageName) . '::' . Str::snake(request()->modelName) . '.successfully.' . $action);
    }

    /**
     * @return string
     */
    public function getIndexRouteName(): string
    {
        return Str::beforeLast(request()->route()->getName(), '.') . '.index';
    }

    /**
     * @param Model $model
     * @param string $action
     * @return bool
     */
    public function hasRecordProtected(Model $model, string $action): bool
    {
        $recordProtection = $this->getRecordProtection($model);

        if ($recordProtection['is_protected']) {
            if (in_array($action, $recordProtection['except'])) {
                return false;
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $model
     * @return array
     */
    protected function getRecordProtection($model): array
    {
        $recordProtection = [
            'is_protected' => false,
            'except'       => [],
        ];

        $protectedRecords = config('tpx_' . Str::snake(request()->packageName) . '.protected_records.' . Str::snake(class_basename($model)));

        if ($protectedRecords) {
            $recordProtection['is_protected'] = in_array(
                $model->{$protectedRecords['selector']},
                $protectedRecords['records']
            );
            $recordProtection['except'] = array_get($protectedRecords, 'except', []);
        }

        return $recordProtection;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function counters()
    {
        return response((new CountersService)->getData());
    }
}
