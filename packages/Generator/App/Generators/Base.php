<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

abstract class Base
{
    const FIELD_TYPE_TEXT = 'text';
    const FIELD_TYPE_BOOLEAN = 'boolean';
    const FIELD_TYPE_CHECKBOX = 'checkbox';
    const FIELD_TYPE_TEXTAREA = 'textarea';
    const FIELD_TYPE_IMAGE = 'image';
    const FIELD_TYPE_EDITOR = 'editor';
    const FIELD_TYPE_TIMESTAMP = 'timestamp';
    const FIELD_TYPE_INTEGER = 'integer';
    const FIELD_TYPE_DOUBLE = 'double';
    const FIELD_TYPE_DATE = 'date';
    const FIELD_TYPE_FOREIGN = 'foreign';
    const FIELD_TYPE_VS_MULTIPLE = 'vs_multiple';

    const ENTER = "\n";
    const ENTER2 = "\n\n";

    const TAB1 = "\t";
    const TAB2 = "\t\t";
    const TAB3 = "\t\t\t";
    const TAB4 = "\t\t\t\t";
    const TAB5 = "\t\t\t\t\t";
    const TAB6 = "\t\t\t\t\t\t";
    const TAB7 = "\t\t\t\t\t\t\t";

    /*
     * @var array
     */
    private $config;

    /*
     * @var string
     */
    private $modelName;

    abstract function handle();

    /**
     * Base constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string|null
     */
    public function getMigrationNextFileName():? string
    {
        $files = glob($this->getPackagePath() . 'database/migrations/*');
        $file = count($files) ? end($files) : null;
        $number = 1;

        if ($file) {
            $parts = explode('_', $file);
            $number = (int) $parts[3];
            $number++;
        }

        return str_pad($number, 6, 0);
    }


    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param string $modelName
     * @return $this
     */
    public function setModelName(string $modelName): self
    {
        $this->modelName = $modelName;
        return $this;
    }

    /**
     * @return string
     */
    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * @return string
     */
    public function getModelNameSnake(): string
    {
        return Str::snake($this->modelName);
    }

    /**
     * @return string
     */
    public function getModelVar(): string
    {
        return Str::camel($this->getModelName());
    }

    /**
     * @return string
     */
    public function getViewsPath(): string
    {
        $parts = explode('App', __DIR__);
        return $parts[0] . 'views/';
    }

    /**
     * @param string $view
     * @param array $data
     * @param string $file
     * @param array $options
     * @return string
     */
    public function viewToPackageFile(string $view, array $data, string $file, array $options = []): string
    {
        $ext = array_get($options, 'fileExt', '.php');

        $fullPath = $this->getPackagePath() . $file . $ext;

        $this->checkPath(pathinfo($fullPath)['dirname']);

        $prefixContent = isset($options['prefixContent']) ? $options['prefixContent'] : '';

        $viewFile = $this->getViewsPath() . $view . '.blade.php';
        if (!is_file($viewFile)) {
            $viewFile = $this->getViewsPath() . $view . '.php';
        }

        $content = $prefixContent . view()->file($viewFile, $data)->render();

        file_put_contents(
            $fullPath,
            $content
        );

        return $content;
    }

    /**
     * @param string $dir
     */
    public function checkPath(string $dir)
    {
        $parts = explode('packages/', $dir);
        $dir = $parts[0] . 'packages/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        foreach (explode('/', trim($parts[1],'/')) as $subDir) {
            $dir .= $subDir . '/';
            if (!is_dir($dir)) {
                mkdir($dir);
            }
        }
    }

    /**
     * @return string
     */
    public function getPackagePath(): string
    {
        return base_path('packages') . '/' . $this->config['package_name'] . '/';
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->config['package_name'];
    }

    /**
     * @return string
     */
    public function getPackageNameSnake(): string
    {
        return Str::snake($this->getPackageName());
    }

    /**
     * @return string
     */
    public function getPackageNameKebab(): string
    {
        return Str::kebab($this->getPackageName());
    }

    public function getModelConfig(): array
    {
        return $this->config['models'][$this->getModelName()];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasAction(string $name): bool
    {
        $modelConfig = $this->getModelConfig();
        $actions = array_get($modelConfig, 'actions', []);

        // show actions default disable
        if ($name === 'show') {
            return array_get($actions, $name, false);
        }

        return array_get($actions, $name, true);
    }

    /**
     * @return array
     */
    public function getImageAttributes(): array
    {
        $items = [];
        foreach ($this->getModelConfig()['fields'] as $field) {
            if ($field['type'] === self::FIELD_TYPE_IMAGE) {
                $items[] = $field['name'];
            }
        }

        return $items;
    }

    /**
     * @return array
     */
    public function getVsMultipleFields(): array
    {
        $items = [];
        foreach ($this->getModelConfig()['fields'] as $field) {
            if ($field['type'] === self::FIELD_TYPE_VS_MULTIPLE) {
                $items[] = $field;
            }
        }

        return $items;
    }

    /**
     * @return bool
     */
    public function getWithTimestamps(): bool
    {
        $vs = array_get($this->getModelConfig(), 'vs', false);
        if ($vs) {
            return false;
        }

        return array_get($this->getModelConfig(), 'timestamps', false);
    }

    /**
     * @return bool
     */
    public function getWithSluggable(): bool
    {
        $fields = array_column($this->getMainFields(), 'name');

        return in_array('slug', $fields) || in_array('alias', $fields);
    }

    /**
     * @return bool
     */
    public function getWithIncrements(): bool
    {
        return !array_get($this->getModelConfig(), 'vs', false);
    }


    /**
     * @return array
     */
    public function getTranslatableFields(): array
    {
        $items = [];
        foreach ($this->getModelConfig()['fields'] as $field) {
            if (array_get($field, 'translatable', false)) {
                $items[] = $field;
            }
        }

        return $items;
    }

    /**
     * @return array
     */
    public function getForiegnData(): array
    {
        $items = [];
        foreach ($this->getModelConfig()['fields'] as $field) {
            if (array_get($field, 'foreign', false)) {
                $items[$field['name']] = $field['foreign'];
            }
        }

        return $items;
    }

    /**
     * @return array
     */
    public function getTranslatableAttributes(): array
    {
        $items = [];
        foreach ($this->getTranslatableFields() as $field) {
            $items[] = $field['name'];
        }

        return $items;
    }

    /**
     * @return array
     */
    public function getMainFields(): array
    {
        $items = [];
        foreach ($this->getModelConfig()['fields'] as $field) {
            if (!array_get($field, 'translatable', false)) {
                $items[] = $field;
            }
        }

        return $items;
    }

    /**
     * @param array $data
     * @param string $column
     * @param string $value
     * @return bool
     */
    public function existsInArrayColumnValue(array $data, string $column, string $value): bool
    {
        foreach ($data as $item) {
            if (isset($item[$column]) && $item[$column] == $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        $table = '';
        if (isset($this->getModelConfig()['table'])) {
            $table = $this->getModelConfig()['table'];
        } else {
            $nameByModel = Str::snake(Str::plural($this->getModelName()));
            $nameByPackage = Str::snake($this->getPackageName());
            $table = $nameByModel === $nameByPackage
                ? $nameByModel
                : $nameByPackage . '_' . $nameByModel;
        }

        return $table;
    }

    /**
     * @return string
     */
    public function getTableNameTranslation(): string
    {
        return $this->getTableName() . '_translation';
    }

    /**
     * @return string
     */
    public function getForeignField(): string
    {
        return isset($this->getModelConfig()['foreign_field'])
            ? $this->getModelConfig()['foreign_field']
            : Str::snake($this->getModelName()) . '_id';
    }

    /**
     * @return string
     */
    public function getModelNameSingular(): string
    {
        return isset($this->getModelConfig()['name_singular'])
                ? $this->getModelConfig()['name_singular']
                : $this->getModelName();
    }

    /**
     * @return string
     */
    public function getModelNamePlural(): string
    {
        return isset($this->getModelConfig()['name_plural'])
                ? $this->getModelConfig()['name_plural']
                : Str::plural($this->getModelName());
    }

    /**
     * @return string
     */
    public function getNameRouteController(): string
    {
        return Str::snake($this->getModelNamePlural());
    }

    /**
     * @return string
     */
    public function getModelForeignField(): string
    {
        return isset($this->getModelConfig()['foreign_field'])
            ? $this->getModelConfig()['foreign_field']
            : Str::snake($this->getModelName()) . '_id';
    }

    /**
     * @return array
     */
    public function getModelsConfig(): array
    {
        $data = [];
        foreach ($this->getConfig()['models'] as $modelName => $modelConf) {
            $this->setModelName($modelName);

            $data[$modelName] = $modelConf;

            $crud = array_get($modelConf, 'crud', true);
            $vs = array_get($modelConf, 'vs', false);

            if ($crud && !$vs) {
                foreach (['index', 'create', 'update', 'show', 'destroy'] as $action) {
                    $data[$modelName]['actions'][$action] = $this->hasAction($action);
                }
            } else {
                $data[$modelName]['actions'] = [
                    'index'=>false, 'create'=>false, 'update'=>false, 'show'=>false, 'destroy'=>false,
                ];
            }
            $data[$modelName]['crud'] = $crud;
            $data[$modelName]['vs'] = $vs ;
            $data[$modelName]['routeNameController'] = $this->getNameRouteController();
            $data[$modelName]['routePathController'] = array_get($modelConf, 'route', str_replace('_', '-', $this->getNameRouteController()));
            $data[$modelName]['namePlural'] = $this->getModelNamePlural();
            $data[$modelName]['nameSnake'] = Str::snake($modelName);
            $data[$modelName]['nameCamel'] = Str::camel($modelName);
        }

        return $data;
    }
}
