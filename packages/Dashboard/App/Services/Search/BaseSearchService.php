<?php

namespace Packages\Dashboard\App\Services\Search;

use Packages\Dashboard\App\Services\Config\ConfigService;

/**
 * Class BaseSearchService
 * @package Packages\Dashboard\App\Services\Search
 */
class BaseSearchService
{
    /**
     * @return $this
     */
    public static function make(): self
    {
        return new static;
    }

    /**
     * @param string $q
     * @return array
     */
    public function search(string $q): array
    {
        $items = [];
        foreach (ConfigService::make()->getPackagesSearchItems() as $packageConfig) {
            $resultModels = [];
            $resultStatic = [];

            foreach (array_get($packageConfig, 'models', []) as $modelConfig) {
                $rows = $modelConfig['class']::query()->search($q)->get();
                if ($rows->count()) {
                    foreach ($rows as $row) {
                        $modelConfig['items'] = [
                            'id' => $row->id,
                            'title' => method_exists($row, 'getSearchableTitle')
                                ? $row->getSearchableTitle()
                                : $row->title,
                        ];
                    }
                    $resultModels[] = $modelConfig;
                }
            }

            foreach (array_get($packageConfig, 'static', []) as $staticConfig) {
                if (substr_count(strtolower($staticConfig['title']), strtolower($q))) {
                    $resultStatic[] = $staticConfig;
                }
            }

            if (!empty($resultModels) || !empty($resultStatic)) {
                $packageConfig['models'] = $resultModels;
                $packageConfig['static'] = $resultStatic;
                $items[] = $packageConfig;
            }
        }

        return $items;
    }

    public function test()
    {
        dd($this->search('User'));
    }
}
