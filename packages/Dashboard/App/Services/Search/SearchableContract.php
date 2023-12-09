<?php

namespace Packages\Dashboard\App\Services\Search;

/**
 * Interface SearchableContract
 * @package Packages\Dashboard\App\Services\Search
 */
interface SearchableContract
{
    /**
     * @return array
     */
    function searchableAttributes(): array;
}
