<?php

namespace Packages\Dashboard\App\Services\Search;

/**
 * Class SearchService
 * @package Packages\Dashboard\App\Services\Search
 */
class SearchService extends BaseSearchService
{
    public function test()
    {
        dd($this->search('User'));
    }
}
