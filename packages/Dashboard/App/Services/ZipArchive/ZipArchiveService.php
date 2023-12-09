<?php

namespace Packages\Dashboard\App\Services\ZipArchive;

use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ZipArchiveService
{
    /**
     * @param string $source
     * @param string $destination
     * @return bool
     */
    function makeFromDir(string $source, string $destination): bool
    {
        if (!file_exists($source)) {
            return false;
        }

        $rootPath = realpath($source);

        $zip = new ZipArchive();
        $zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        return $zip->close();
    }
}
