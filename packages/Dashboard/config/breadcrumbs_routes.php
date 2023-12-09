<?php
use Packages\Dashboard\App\Services\Config\ConfigService;

foreach ((new ConfigService)->getBreadcrumbsFiles() as $file) {
    include_once $file;
}
