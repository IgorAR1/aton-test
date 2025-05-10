<?php

namespace App\Core\Cache\FileSystem;

class MultiFileCache extends FileCache
{
    protected function getFile(string $key, bool $mkdir = false): string
    {
        $parts = array_slice(str_split($hash = sha1($key), 2), 0, 2);
        $dir = $this->directory . \DIRECTORY_SEPARATOR . implode(\DIRECTORY_SEPARATOR, $parts);

        if (!is_dir($dir) && $mkdir) {
            mkdir($dir, 0777, true);
        }

        return $dir . \DIRECTORY_SEPARATOR . $hash;
    }

    protected function _fetch(array $keys): iterable
    {
        $result = [];

        foreach ($keys as $key) {
            $file = $this->getFile($key);

            if (!is_file($file)) {
                continue;
            }

            $handle = fopen($file, 'r');

            $expire = fgets($handle);
            if ($expire < time()) {
                unlink($file);
                fclose($handle);

                continue;
            }

            try {
                $result[$key] = $this->unserialize(fgets($handle));
            } catch (\ErrorException $e) {
                unlink($file);
            }

            fclose($handle);
        }

        return $result;
    }

    protected function _save(array $data): array|bool
    {
        $failed = [];

        foreach ($data as $record) {
            $file = $this->getFile($record['key'], true);
            if (!$this->_write($file, $record['expire'] . "\n" . serialize($record['value']))) {
                $failed[$record['key']] = $record['value'];
            }
        }

        return $failed;
    }

    protected function _write(string $file, string $data): bool
    {
        set_error_handler(static fn($type, $message, $file, $line) => throw new \ErrorException($message, 0, $type, $file, $line));

        try {
            $handle = fopen($file, 'c');
            $success = fwrite($handle, $data);
        } catch (\ErrorException $e) {
            throw $e;
        } finally {
            fclose($handle);
            restore_error_handler();
        }

        return $success;
    }

    protected function _have(string $key): bool
    {
        $file = $this->getFile($key);

        return is_file($file) && $this->_fetch([$key]);
    }

    protected function _delete(array $keys): bool
    {
        $ok = true;

        foreach ($keys as $key) {
            $file = $this->getFile($key);
            $ok = (!is_file($file) || unlink($file) || !file_exists($file)) && $ok;
        }

        return $ok;
    }

    public function _clear(): bool
    {
        return rmdir($this->directory, true);
    }
}