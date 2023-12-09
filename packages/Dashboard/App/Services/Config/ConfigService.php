<?php

/**
 * @package     Dashboard
 * @version     0.1.0
 * @author      LLC Studio <hello@digitalp.co>
 * @license     MIT
 * @copyright   2015, LLC
 * @link        https://digitalp.com
 */

namespace Packages\Dashboard\App\Services\Config;

use Illuminate\Support\Str;
use Packages\Dashboard\App\Models\Role;
use Packages\Dashboard\App\Services\Search\SearchService;

class ConfigService
{
    /**
     * @var array
     */
    private $packagesConfig;

    /**
     * @return $this
     */
    public static function make(): self
    {
        return new static;
    }

    /**
     * @return array
     */
    public function getPackagesConfig(): array
    {
        if (!$this->packagesConfig) {

            $this->packagesConfig = [];

            foreach (glob(config_path() . '/tpx_*') as $file) {
                $packageConfig = $this->fetchPackageConfig($file);
                $packageId = $packageConfig['id'];

                $appPath = '/App/Providers/' . $packageId . 'ServiceProvider.php';
                $spLocalFile = base_path() . '/packages/' . $packageId . $appPath;

                if (array_get($packageConfig, 'enabled', true) && is_file($spLocalFile)) {
                    $this->packagesConfig[$packageConfig['id']] = $packageConfig;
                }
            }
        }

        return $this->packagesConfig;
    }

    /**
     * @param string $file
     * @return array
     */
    public function fetchPackageConfig(string $file): array
    {
        return require($file);
    }

    /**
     * @return array
     */
    public function getPackages(): array
    {
        $data = [];
        foreach ($this->getPackagesConfig() as $packageConfig) {
            $data[] = $packageConfig['id'];
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getBreadcrumbsFiles(): array
    {
        $data = [];
        foreach ($this->getPackages() as $package) {
            $localFile = base_path() . '/packages/' . $package . '/App/breadcrumbs.php';

            if (is_file($localFile)) {
                $data[] = $localFile;
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        $data = [];
        foreach ($this->getPackagesConfig() as $packageConfig) {

            if (array_get($packageConfig, 'enabled', true)) {
                $data = array_merge($data, $this->getPackagePermissions($packageConfig));
            }
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getPermissionsMapping(): array
    {
        $data = [];
        foreach ($this->getPackagesConfig() as $packageConfig) {
            $data = array_merge($data, array_get($packageConfig, 'permissions_mapping', []));
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getPackagePermissions(array $packageConfig): array
    {
        $permissionsConfig = array_get($packageConfig, 'permissions', []);
        $defaultActions = ['index', 'create', 'update', 'destroy'];

        $data = [];

        foreach ($permissionsConfig as $model => $modelPermissions) {
            $modelPermissions = is_array($modelPermissions)
                ? $modelPermissions
                : $defaultActions;


            foreach ($modelPermissions as $key => $value) {
                if (is_string($value)) {
                    $data[implode('.', [Str::snake($packageConfig['id']), $model, $value])] = [Role::SLUG_ADMIN];
                } else {
                    if ($key === '*') {
                        foreach ($defaultActions as $action) {
                            $data[implode('.', [Str::snake($packageConfig['id']), $model, $action])] = $value;
                        }
                    } else {
                        $data[implode('.', [Str::snake($packageConfig['id']), $model, $key])] = $value;
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getNavigation(): array
    {
        $data = [];
        foreach ($this->getPackagesConfig() as $packageConfig) {

            if (array_get($packageConfig, 'enabled', true)) {
                foreach (array_get($packageConfig, 'navigation', []) as $navKey => $navItems) {

                    if (can($navItems['route'])) {
                        $navItems['rank'] = array_get($navItems, 'rank', 0);
                        if (!isset($navItems['url'])) {
                            $navItems['url'] = route($navItems['route']);
                        }

                        if (!empty($navItems['children']) && is_array($navItems['children'])) {
                            foreach ($navItems['children'] as $childKey => & $chilItem) {
                                if (!isset($chilItem['url'])) {
                                    $chilItem['url'] = route($chilItem['route']);
                                }

                                if (!can($chilItem['route'])) {
                                    unset($navItems['children'][$childKey]);
                                }
                            }
                            if (!count($navItems['children'])) {
                                unset($navItems['children']);
                            }
                        }

                        $data[$navKey] = $navItems;
                    }
                }
            }
        }


        usort($data, function ($a, $b) {
            return $a['rank'] >= $b['rank'] ? 1 : -1;
        });
        return $data;
    }

    /**
     * @return array
     */
    public function getServiceProviders(): array
    {
        $data = [];

        foreach ($this->getPackagesConfig() as $packageConfig) {
            $packageId = $packageConfig['id'];

            $data[] = 'Packages\\' . $packageId .'\\App\\Providers\\' . $packageId . 'ServiceProvider';
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getPackagesSearchItems(): array
    {
        $data = [];

        foreach ($this->getPackagesConfig() as $packageConfig) {

            $packageId = $packageConfig['id'];

            if (array_get($packageConfig, 'enabled', true)) {
                $search = array_get($packageConfig, 'search');
                if ($search) {
                    $search['id'] = $packageId;

                    // filter models content by permissions
                    $models = array_filter(array_get($search, 'models', []), function ($item) {
                        return can($item['permission']);
                    });

                    foreach ($models as & $item) {
                        if (empty($item['title'])) {
                            $item['title'] = Str::plural(Str::afterLast($item['class'], "\\"));
                        }
                    }
                    $search['models'] = array_values($models);

                    // filter static content by permissions
                    $search['static'] = array_filter(array_get($search, 'static', []), function ($item) {
                        return can($item['permission']);
                    });

                    //resolve titles
                    $search['static'] = array_values(array_map(function ($item) {
                        if (empty($item['title'])) {
                            list($package, $modelPlural, $action) = explode('.', $item['permission']);

                            $item['title'] = trans($package . '::' . Str::singular($modelPlural) . '.title.' . $action);
                        }
                        return $item;
                    }, $search['static']));

                    $data[] = $search;
                }
            }
        }

        return $data;
    }

    /**
     * @param string|null $dir
     * @return string
     */
    protected function getLocalPath(string $dir = null): string
    {
        $segments = explode('\\', static::class);

        $path =  base_path() . '/packages/' . $segments[0] . '/' . $segments[1];

        if ($dir) {
            $path.= '/' . $dir;
        }

        return $path;
    }

    /**
     * @return array
     */
    public function getSyncCommands(): array
    {
        $data = [];

        foreach ($this->getPackagesConfig() as $packageConfig) {
            $packageId = $packageConfig['id'];

            $namespace = 'Packages\\' . $packageId .'\\App\\Console\\SyncCommand';

            if (class_exists($namespace)) {
                $data[] = $namespace;
            } else {
                $namespace = 'Packages\\' . $packageId .'\\App\\Console\\BaseSyncCommand';
                if (class_exists($namespace)) {
                    $data[] = $namespace;
                }
            }
        }

        return $data;
    }

    /**
     * @param string $packageName
     * @param string $navKey
     * @return array
     */
    public function getPackageMenuItems(string $packageName, string $navKey = 'navigation'): array
    {
        $items = config('tpx_' . Str::snake($packageName) . '.' . $navKey, []);
        $data = [];
        foreach ($items as $key => $item) {
            $data[$key] = $item;
            if (!empty($item['children'])) {
                foreach ($item['children'] as $childKey => $childItem) {
                    $data[$childKey] = $childItem;
                }
            }
        }

        return $data;
    }

    /**
     * @param string $packageName
     * @param string $modelName
     * @return array|null
     */
    public function getActiveMenuItem(string $packageName, string $modelName):? array
    {
        $data = $this->getPackageMenuItems($packageName);
        $menuItem = array_get($data, Str::snake($packageName)  . '::' . Str::snake($modelName));
        if (!$menuItem) {
            $data = $this->getPackageMenuItems($packageName, 'navigation_extra');
            $menuItem = array_get($data, Str::snake($packageName)  . '::' . Str::snake($modelName));
        }

        return $menuItem;
    }
}
