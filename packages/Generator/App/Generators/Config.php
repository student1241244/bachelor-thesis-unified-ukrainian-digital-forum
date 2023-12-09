<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class Config extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'navigation' => $this->getNavigation(),
            'permissions' => $this->getPermissions(),
        ];

        $content = $this->viewToPackageFile('config', $data, 'config/config', [
            'prefixContent' => "<?php\n",
        ]);

        file_put_contents($this->getConfigFileName(), $content);
    }

    /**
     * @return string
     */
    public function getConfigFileName(): string
    {
        return config_path() . '/tpx_' . Str::snake($this->getPackageName()) . '.php';
    }

    /**
     * @return string
     */
    public function getNavigation(): string
    {
        $data = self::TAB1 . '\'navigation\' => [' . self::ENTER;

        foreach ($this->getConfig()['models'] as $modelName => $modelConfig) {
            $crud = array_get($modelConfig, 'crud', true);
            $vs = array_get($modelConfig, 'vs', false);
            if (!$crud || $vs) {
                continue;
            }

            $this->setModelName($modelName);

            $confNav = array_get($modelConfig, 'navigation', []);

            $icon = isset($confNav['icon']) ? $confNav['icon'] : 'fa-folder';
            $color = isset($confNav['color']) ? $confNav['color'] : '#fff';
            $rank = isset($confNav['rank']) ? $confNav['rank'] : 0;

            $data .= self::TAB2 . '\''.$this->getPackageNameSnake().'::'.Str::snake($modelName).'\' => [' . self::ENTER;
                $data .= self::TAB3 . '\'title\'    => \''.$this->getPackageNameSnake().'::'.Str::snake($modelName).'.title.menu\',' . self::ENTER;
                $data .= self::TAB3 . '\'route\'    => \''.$this->getPackageNameSnake().'.'. $this->getNameRouteController() .'.index\',' . self::ENTER;
                $data .= self::TAB3 . '\'icon\'     => \'fa '.$icon.' fa-fw\',' . self::ENTER;
                $data .= self::TAB3 . '\'color\'    => \''.$color.'\',' . self::ENTER;
                $data .= self::TAB3 . '\'rank\'     => '.$rank.',' . self::ENTER;
            $data .= self::TAB2 . '],' . self::ENTER;
        }

        $data.= self::TAB1 . '],';

        return $data;
    }

    /**
     * @return string
     */
    public function getPermissions(): string
    {
        $data = self::TAB1 . '\'permissions\' => [' . self::ENTER;
        foreach ($this->getConfig()['models'] as $modelName => $modelConfig) {
            $this->setModelName($modelName);

            if (!isset($modelConfig['actions'])) {
                $data.= self::TAB2 . '\''. $this->getNameRouteController() .'\' => \'*\',' . self::ENTER;
            } else {
                $data.= self::TAB2 . '\''. $this->getNameRouteController() . '\' => [' . self::ENTER;
                foreach ($modelConfig['actions'] as $action => $is) {
                    if ($is) {
                        $data .= self::TAB3 . '\'' . $action . '\',' . self::ENTER;
                    }
                }
                $data.= self::TAB2 . '],' . self::ENTER;
            }
        }
        $data.= self::TAB1 . '],';

        return $data;
    }
}
