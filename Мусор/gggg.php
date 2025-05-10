<?php

namespace App\Core\Cache;

use Psr\Cache\CacheItemInterface;

class FileCache extends AbstractCache
{
    private string $directory;
    public function __construct(?string $directory = null)
    {
//        dd(func_get_args());
        $this->init($directory);
    }

    private function init(?string $directory, ?string $file): void
    {
        if (!$directory) {
            $directory = sys_get_temp_dir() . \DIRECTORY_SEPARATOR . 'cache';
        }

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

//        if (!$file) {
//            $file = $directory . \DIRECTORY_SEPARATOR . base64_decode(random_bytes(1));
//        } else {
//            $file = $directory . \DIRECTORY_SEPARATOR . $file;
//        }
    }

    protected function getFile(string $key): string
    {
        $parts = array_slice(str_split($hash = sha1($key), 2), 0, 2);

        return $this->directory.'/'.implode('/', $parts).'/'.$hash;
    }

    public function _write(string $file, string $data, ?int $expiresAt = null): bool///TODO private
    {
        set_error_handler(static fn($type, $message, $file, $line) => throw new \ErrorException($message, 0, $type, $file, $line));

        try {
            $handle = fopen($file, 'a');

            $success = fwrite($handle, $data);

            fclose($handle);

            if (null !== $expiresAt) {
                touch($handle, $expiresAt ?: time() + 31556952);
            }
        } finally {
            restore_error_handler();
        }

        return $success;
    }

    public function _fetch(array $keys): iterable///TODO
    {
        $h = fopen($this->file, 'r');

        $result = [];
        while (!feof($h)) {
            $line = fgets($h);
            foreach ($keys as $key) {
                if (unserialize($line)[$key] === $key) {
                    $result[] = $line;
                }
            }
        }

        fclose($h);

        return $result;
    }

    private function _save(array $data): bool
    {

    }

//    private function _have(): bool
//    {
//
//    }
//    private function _delete(): bool
//    {
//
//    }
//
//    private function _clear(): bool
//    {
//
//    }


    public function getItem(string $key): CacheItemInterface
    {
        // TODO: Implement getItem() method.
    }

    public function getItems(array $keys = []): iterable
    {
        // TODO: Implement getItems() method.
    }

    public function hasItem(string $key): bool
    {
        // TODO: Implement hasItem() method.
    }

    public function clear(): bool
    {
        // TODO: Implement clear() method.
    }

    public function deleteItem(string $key): bool
    {
        // TODO: Implement deleteItem() method.
    }

    public function deleteItems(array $keys): bool
    {
        // TODO: Implement deleteItems() method.
    }

    public function save(CacheItemInterface $item): bool
    {
        // TODO: Implement save() method.
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        // TODO: Implement saveDeferred() method.
    }

    public function commit(): bool
    {
        // TODO: Implement commit() method.
    }


}