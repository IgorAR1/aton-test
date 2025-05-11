<?php

namespace App\Core\Cache\FileSystem;

use App\Core\Cache\AbstractCache;

abstract class FileCache extends AbstractCache
{
    //TODO ненужный класс
    protected string $directory;

    public function __construct(?string $directory = null)
    {
        if (!$directory) {
            $directory = sys_get_temp_dir() . \DIRECTORY_SEPARATOR . 'cache';
        }

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $this->directory = $directory;
    }
}