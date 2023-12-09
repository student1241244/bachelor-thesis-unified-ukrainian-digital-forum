<?php

namespace Packages\Dashboard\App\Traits;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait RenderHtmlTagsTrait
{
    /**
     * @param $model
     * @param array $extraActions
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function renderRawActions($actions, array $extraActions = [])
    {
        $renderTags = [];

        foreach ($actions as $action) {
            $routeName = $action['route'];

            $attributes = [
                'href' => array_get($action, 'url', '#'),
                'title' => $action['title'],
                'class' => array_get($action, 'class'),
            ];

            if (isset($action['data-url'])) {
                $attributes['data-url'] = $action['data-url'];
            }

            foreach (array_get($action, 'model', []) as $key => $val) {
                $attributes['data-' . $key] = $val;
            }

            $renderTags[] = Route::has($routeName) && can($routeName)
                ? $this->renderLink($attributes, $action['title'], $action['icon'])
                : '';
        }

        return $this->formatActionsCell($renderTags);
    }

    /**
     * @param array $actions
     * @return string
     */
    protected function formatActionsCell(array $actions): string
    {
        $actionsString = implode(' ', $actions);

        if (config('tpx_dashboard.data_tables.actions') === self::ACTIONS_DROPDOWN) {
            return trim(view('tpx_dashboard::datatables.actions_dropdown', compact('actionsString')));
        }

        return $actionsString;
    }


    /**
     * @param array $attributes
     * @param null $linkText
     * @param null $icon
     * @return string
     */
    protected function renderLink(array $attributes, $linkText = null, $icon = null)
    {
        array_add($attributes, 'data-toggle', 'tooltip');
        array_add($attributes, 'data-placement', 'top');

        $icon = $icon ? sprintf('<i class="%s"></i>', $icon) : '';

        return sprintf('<a%s>%s %s</a>',
            $this->renderAttributes($attributes),
            $icon,
            $linkText
        );
    }


    /**
     * @param $model
     * @param array $extraActions
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function renderActions($model, array $extraActions = [])
    {
        $mapAbleActions = [
            'edit' => 'isEditable',
        ];

        $actions = isset($this->rowActions) ? $this->rowActions : array_merge($extraActions, static::$defaultActions);
        $renderTags = [];

        $recordProtection = $this->recordProtected($model);

        if ($recordProtection['is_protected'] && !$recordProtection['except']) {
            return trans('dashboard::dashboard.record_protected');
        }

        foreach ($actions as $action) {
            $allowMethod = array_get($mapAbleActions, $action);
            if ($allowMethod &&
                method_exists($model, $allowMethod) &&
                !$model->{$allowMethod}()
            ) {
                continue;
            }

            $routeName = $this->getPackage() . '.' . $this->getModel() . '.' . $action;

            $renderTags[] = $this->actionDisplayed($recordProtection, $action) && Route::has($routeName) && can($routeName)
                ? $this->renderTag($action, route($routeName, $model))
                : '';
        }

        return $this->formatActionsCell($renderTags);
    }

    /**
     * @param $recordProtection
     * @param $action
     * @return bool
     */
    protected function actionDisplayed($recordProtection, $action): bool
    {
        if (!$recordProtection['except'] || !$recordProtection['is_protected']) {
            return true;
        }

        return ($recordProtection['is_protected'] && in_array($action, $recordProtection['except']));
    }

    /**
     * @param $model
     * @return array
     */
    protected function recordProtected($model): array
    {
        $recordProtection = [
            'is_protected' => false,
            'except'       => [],
        ];

        $protectedRecords = config('tpx_' . Str::snake(request()->packageName) . '.protected_records.' . $this->getModel(false));

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
     * @param $action
     * @param $route
     * @param null $linkText
     * @param null $title
     * @param null $class
     * @return mixed
     */
    protected function renderTag($action, $route, $linkText = null, $title = null, $class = null)
    {
        $renderFunction = 'render' . ucfirst($action) . 'Link';

        $attributes = [
            'title' => ($title ?: trans('dashboard::dashboard.' . $action)),
            'href'  => $route,
        ];

        return $this->{$renderFunction}($attributes, $linkText, $class);
    }

    /**
     * @param $attributes
     * @param $linkText
     * @param $class
     * @return string
     */
    protected function renderEditLink($attributes, $linkText, $class)
    {
        $attributes = array_add($attributes, 'class', ($class ?: 'btn btn-sm'));

        //return $this->renderLink($attributes, trans('dashboard::dashboard.edit'), 'fa fa-pencil');
        return $this->renderLink($attributes, '', 'fa fa-pencil');
    }

    /**
     * @param $attributes
     * @param $linkText
     * @param $class
     * @return string
     */
    protected function renderDuplicateLink($attributes, $linkText, $class)
    {
        $attributes = array_add($attributes, 'class', ($class ?: 'btn btn-primary'));

        return $this->renderLink($attributes, trans('dashboard::dashboard.duplicate'), 'fa fa-copy');
    }

    /**
     * @param $attributes
     * @param $linkText
     * @param $class
     * @return string
     */
    protected function renderDestroyLink($attributes, $linkText, $class)
    {
        $attributes = array_add($attributes, 'class', ($class ?: 'btn btn-sm  removal-confirmation-alert'));

        //return $this->renderLink($attributes, trans('dashboard::dashboard.delete'), 'fa fa-trash');
        return $this->renderLink($attributes, '', 'fa fa-trash');
    }

    /**
     * @param $attributes
     * @param $linkText
     * @param $class
     * @return string
     */
    protected function renderViewLink($attributes, $linkText, $class)
    {
        $attributes = array_add($attributes, 'class', ($class ?: 'btn btn-xs btn-view'));

        return $this->renderLink($attributes, trans('dashboard::dashboard.view'), 'fa fa-eye');
    }

    /**
     * @param array $attributes
     * @return string
     */
    protected function renderAttributes(array $attributes)
    {
        list($keys, $values) = array_divide($attributes);

        return implode(array_map(function ($attribute, $value) {
            return sprintf(' %s="%s"', $attribute, $value);
        }, $keys, $values));

    }
}
