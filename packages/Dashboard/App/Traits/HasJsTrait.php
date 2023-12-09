<?php

namespace Packages\Dashboard\App\Traits;

trait HasJsTrait
{
    private $scriptFiles = [];

    /**
     * @param string $file
     * @return $this
     */
    public function addScriptFile(string $file)
    {
        $this->scriptFiles[] = $file;
        return $this;
    }

    /**
     * @return array
     */
    public function getScriptFiles(): array
    {
        return $this->scriptFiles;
    }
}
