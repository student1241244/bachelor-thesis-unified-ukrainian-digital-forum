<?php


namespace Packages\Generator\App;

use Exception;
use Packages\Generator\App\Generators\{Breadcrumbs,
    ComposerJson,
    Config,
    Controller,
    Form,
    FormRequest,
    IndexRequest,
    Lang,
    Migration,
    MigrationLang,
    Model,
    ModelTranslation,
    Routes,
    ServiceProvider};
use Packages\Generator\App\Generators\CrudService;
use Packages\Generator\App\Generators\Index;

class GenerateService
{
    /*
     * @var array
     */
    private $config;

    /**
     * @param string $file
     * @return $this
     * @throw Exception
     */
    public function setConfigFromFile(string $file): self
    {
        $fullPath = resource_path('packages/' . $file . '.php');
        if (is_file($fullPath)) {
            return $this->setConfig(require_once ($fullPath));
        } else {
            throw new Exception("File $fullPath not exists!!!");
        }
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getConfig():? array
    {
        return $this->config;
    }

    /**
     * @return void
     */
    public function handle()
    {
        $packagePath = (new Migration($this->config))->getPackagePath();
        foreach (glob($packagePath . 'database/migrations/*') as $file) {
            unlink($file);
        }

        foreach ($this->config['models'] as $model => $conf) {
            if (!empty($conf['fields'])) {

                (new Migration($this->config))->setModelName($model)->handle();

                $vs = array_get($conf, 'vs', false);
                $crud = array_get($conf, 'crud', true);

                if (!$vs) {
                    (new Lang($this->config))->setModelName($model)->handle();
                    (new Model($this->config))->setModelName($model)->handle();
                    (new ModelTranslation($this->config))->setModelName($model)->handle();
                }


                if ($crud && !$vs) {
                    (new IndexRequest($this->config))->setModelName($model)->handle();
                    (new FormRequest($this->config))->setModelName($model)->handle();
                    (new Controller($this->config))->setModelName($model)->handle();
                    (new Form($this->config))->setModelName($model)->handle();
                    (new Index($this->config))->setModelName($model)->handle();
                    (new CrudService($this->config))->setModelName($model)->handle();
                }
            }
        }

        (new ServiceProvider($this->config))->handle();
        (new Config($this->config))->handle();
        (new Breadcrumbs($this->config))->handle();
        (new Routes($this->config))->handle();
        (new ComposerJson($this->config))->handle();
    }
}
