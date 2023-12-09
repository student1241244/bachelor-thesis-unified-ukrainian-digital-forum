<?php

/**
 * @package     Dashboard
 * @version     0.1.0
 * @author      LLC Studio <hello@digitalp.co>
 * @license     MIT
 * @copyright   2015, LLC
 * @link        https://digitalp.com
 */

namespace Packages\Dashboard\App\Services\Translation;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Packages\Dashboard\App\Models\Language;
use Packages\Dashboard\App\Models\Translation;
use Packages\Dashboard\App\Services\Config\ConfigService;

class TranslationService
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function sync()
    {
        $data = $this->getItems();

        $existsItems = [];

        foreach ($data as $group => $items) {
            foreach ($items as $key => $params) {
                $text = array_get($params, 'text');
                $filteredText = array_filter($text, function ($item) {
                    if (is_array($item)) {
                        return false;
                    }
                    return true;
                });

                $note = array_get($params, 'note');
                if (empty($text) || count($filteredText) !== count($text)) {
                    continue;
                }

                $existsItems[] = $group . '_' . $key;

                $translation = Translation::query()
                    ->where('group', $group)
                    ->where('key', $key)
                    ->first();

                if ($translation && (string)$translation->created_at === (string)$translation->updated_at) {
                    $translation->timestamps = false;
                    $translation->update(compact('text', 'note'), ['timestamps' => false]);
                }

                Translation::firstOrcreate(compact('group', 'key'), compact('text', 'note'));
            }
        }

        $existsItems = array_map(function ($item) {
            return '"'.$item.'"';
        }, $existsItems);

        if (count($existsItems)) {
            Translation::query()->whereRaw('CONCAT(`group`, "_", `key`) NOT IN(' . implode(',', $existsItems) . ')')->delete();
        }
    }

    /**
     * @param string $path
     * @return string
     */
    private function getSourceFile(string $path): string
    {
        $currentLocale = str_replace('{locale}', config('app.locale'), $path);
        if (file_exists($currentLocale)) {
            return $currentLocale;
        } else {
            return str_replace('{locale}', 'en', $path);
        }
    }

    /**
     * Get all translations from packages
     *
     * @return array
     */
    public function getItems(): array
    {
        $packages = (new ConfigService)->getPackages();

        $data = [];
        foreach ($packages as $package) {
            echo $package . "\n";
            $langPackagePath = $this->getSourceFile(base_path() . '/packages/' . $package . '/lang/{locale}/');

            foreach (glob($langPackagePath . '*') as $file) {
                $pi = pathinfo($file);
                if (strstr($pi['filename'], '_note_') === 0) {
                    continue;
                }

                $noteFile = $pi['dirname'] . '/_note_' . $pi['filename'] . '.php';

                echo "\t $file \n";
                $group = Str::snake($package) . '::' . $pi['filename'];
                if (!$this->isEditableGroup($group)) {
                    continue;
                }

                $lines = Arr::dot(require_once $file);

                $notes = [];
                if (is_file($noteFile)) {
                    $notes = Arr::dot(require_once $noteFile);
                }

                foreach ($lines as $lineKey => $lineVal) {
                    $data[$group][$lineKey]['note'] = array_get($notes, $lineKey);
                    foreach (array_keys(Language::getList()) as $locale) {
                        $data[$group][$lineKey]['text'][$locale] = $lineVal;
                    }
                }
            }
        }

        // out of packages
        $mapLocaleGroups = [];

        foreach ($this->getGroupsOutPackages() as $group) {

            if ($this->isEditableGroup($group)) {
                $file = $this->getSourceFile(base_path() . '/lang/{locale}/' . $group . '.php');

                $pi = pathinfo($file);
                if (strstr($pi['filename'], '_note_') === 0) {
                    continue;
                }

                $noteFile = $pi['dirname'] . '/_note_' . $pi['filename'] . '.php';

                $lines = Arr::dot(require_once $file);

                $notes = [];
                if (is_file($noteFile)) {
                    $notes = Arr::dot(require_once $noteFile);
                }

                foreach ($lines as $lineKey => $lineVal) {
                    $data[$group][$lineKey]['note'] = array_get($notes, $lineKey);
                    foreach (array_keys(Language::getList()) as $locale) {

                        if ($locale === app()->getLocale()) {
                            $data[$group][$lineKey]['text'][$locale] = $lineVal;
                        } else {
                            $anotherLocaleLineVal = $lineVal;

                            $localeGroups = [];
                            if (!isset($mapLocaleGroups[$locale]) && !isset($mapLocaleGroups[$locale][$group])) {
                                $fileAnotherLocale = base_path() . '/lang/'.$locale.'/' . $group . '.php';
                                if (is_file($fileAnotherLocale)) {
                                    $localeGroups = Arr::dot(require_once $fileAnotherLocale);
                                }

                                $mapLocaleGroups[$locale][$group] = $localeGroups;
                            }

                            if (isset($mapLocaleGroups[$locale]) && isset($mapLocaleGroups[$locale][$group])) {
                                $data[$group][$lineKey]['text'][$locale] = array_get($mapLocaleGroups[$locale][$group], $lineKey, $lineVal);
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getGroupsOutPackages(): array
    {
        $dir = $this->getSourceFile(base_path() . '/lang/{locale}/');
        return array_map(function($value) {
            return Str::afterLast(Str::beforeLast($value, '.'), '/');
        }, glob($dir . '*'));
    }

    /**
     * @param string $group
     * @return bool
     */
    public function isEditableGroup(string $group): bool
    {
        $confEditable = config('tpx_dashboard.translations.editable_groups');
        if ($confEditable === '*') {
            return true;
        } elseif (in_array($group, $this->getEditableGroups())) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getEditableGroups(): array
    {
        $groups = [];

        foreach ((new ConfigService())->getPackagesConfig() as $packageConfig) {
            $items = array_get($packageConfig, 'translation.editable_groups', []);
            if (is_array($items)) {
                $groups = array_merge($groups, $items);
            }
        }

        return $groups;
    }

    /**
     * @param string $filename
     */
    public function import(string $filename)
    {
        $row = 0;
        $head = [];
        $headMap = [];
        $locales = Language::getList();
        $filesData = [];

        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (!$row){
                    $head = $data;
                    $headMap = array_merge(array_flip($locales), [
                        'Group' => 'group',
                        'Key' => 'key',
                        'Note' => 'note',
                    ]);
                } else {
                    $attributes = [];

                    foreach ($data as $i => $value) {
                        $attributeName = isset($head[$i]) && isset($headMap[$head[$i]]) ? $headMap[$head[$i]] : $head[$i];
                        if ($attributeName) {
                            if (isset($locales[$attributeName])) {
                                $attributes['text'][$attributeName] = $value;
                            } else {
                                $attributes[$attributeName] = $value;
                            }
                        }
                    }

                    $noteFilename = $this->getFilenameByGroup($attributes['group'], '_note_');
                    $modelFilename = $this->getFilenameByGroup($attributes['group']);

                    if (isset($attributes['group']) && isset($attributes['key'])) {
                        Translation::updateOrCreate([
                            'group' => $attributes['group'],
                            'key' => $attributes['key'],
                        ], $attributes);
                    }

                    if (!empty($attributes['note'])) {
                        $filesData[$noteFilename][$attributes['key']] = $attributes['note'];
                    }
                    $filesData[$modelFilename][$attributes['key']] = $attributes['text'][app()->getLocale()];
                }
                $row++;
            }
            fclose($handle);
        }

        if (config('app.env') === 'local') {
            foreach ($filesData as $filename => $data) {
                $this > $this->updateFile($filename, $data);
            }
        }

        Artisan::call('cache:clear');
    }

    /**
     * @param string $filename
     * @param array $data
     */
    private function updateFile(string $filename, array $data)
    {
        $data = array_undot($data);
        file_put_contents($filename, "<?php \nreturn " . $this->convertArray($data) . ";\n");
    }

    /**
     * @param array $expression
     * @return string
     */
    function convertArray(array $expression): string
    {
        $export = var_export($expression, true);
        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
        $export = join(PHP_EOL, array_filter(["["] + $array));

        return $export;
    }

    /**
     * @param string $group
     * @return string
     */
    private function getFilenameByGroup(string $group, string $prefix = ''): string
    {
        if (substr_count($group, '::')) {
            list($package, $model) = explode('::', $group);
            $package = Str::studly($package);

            return base_path('packages/' . $package . '/lang/' . app()->getLocale() . '/' . $prefix . $model . '.php');
        } else {
            return base_path('lang/' . app()->getLocale() . '/' . $prefix . $group . '.php');
        }
    }
}
