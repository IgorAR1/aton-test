<?php

namespace App\Core\Cache\FileSystem;

use SplFileObject;

class SingleFileCache extends FileCache
{

    public function __construct(private string $fileName, ?string $directory = null)
    {
        parent::__construct($directory);

        $this->fileName = $this->directory . \DIRECTORY_SEPARATOR . $this->fileName;

        if (!is_file($this->fileName)) {
            throw new \Exception($this->fileName . ' does not exist'); //TODO: или создать ?
        }
    }

    protected function getFile(): string
    {
        return $this->fileName;
    }

    protected function _fetch(array $keys): iterable
    {
        $result = [];

        try {
            $file = new SplFileObject($this->fileName, 'r');
        } catch (\Exception $exception) {
            return $result;
        }

        foreach ($file as $line) {
            $data = $this->unserialize($line);

            $key = $data['key'];
            $expire = $data['expire'];

            if (isset($keys[$key]) && $expire > microtime(true)) {
                unset($data['expire']);

                $result[] = $data;
            }
        }

        return $result;
    }

    protected function _save(array $data): array|bool
    {
        $failed = [];

        foreach ($data as $record) {
            if (false !== $offset = $this->findOffsetPosition($record['key'])) {
                if (!$this->_rewrite($this->fileName, serialize($record) . "\n", $offset)) {
                    $failed[$record['key']] = $record['value'];
                }
            } else {
                if (!$this->_write($this->fileName, serialize($record) . "\n")) {
                    $failed[$record['key']] = $record['value'];
                }
            }
        }

        return $failed;
    }

    protected function findOffsetPosition(string $key): int|bool
    {
        set_error_handler(static fn($type, $message, $file, $line) => throw new \ErrorException($message, 0, $type, $file, $line));

        try {
            $h = fopen($this->fileName, 'r');

            while (!feof($h)) {
                $offset = ftell($h);

                $line = fgets($h);

                if (!$line) {
                    continue;
                }

                $data = $this->unserialize($line);

                if ($data['key'] === $key) {

                    return $offset;
                }
            }
            fclose($h);
        } finally {
            restore_error_handler();
        }


        return false;
    }

    ///Боюсь представить что будет на файле 100гб))
    protected function _rewrite(string $file, string $data, int $offset): bool
    {
        set_error_handler(static fn($type, $message, $file, $line) => throw new \ErrorException($message, 0, $type, $file, $line));

        $tmp = $this->directory . \DIRECTORY_SEPARATOR . str_replace('/', '-', base64_encode(random_bytes(6)));
        $chunk = 64;

        try {
            $h = fopen($file, 'r');
            $tempH = fopen($tmp, 'c');

            while ($offset > 0) {
                if ($chunk > $offset) {
                    $chunk = $offset;
                }

                $offset = $offset - $chunk;
                fwrite($tempH, fread($h, $chunk));
            }

            fwrite($tempH, $data);

            fgets($h);

            while (!feof($h)) {
                fwrite($tempH, fread($h, $chunk));
            }

            fclose($h);
            fclose($tempH);

            if ('\\' === \DIRECTORY_SEPARATOR) {
                $success = copy($tmp, $file);
            } else {
                $success = rename($tmp, $file);
            }

            return $success;
        } finally {
            restore_error_handler();
            @unlink($tmp);
        }
    }

    protected function _write(string $file, string $data): bool
    {
        set_error_handler(static fn($type, $message, $file, $line) => throw new \ErrorException($message, 0, $type, $file, $line));

        try {
            $handle = fopen($file, 'a');
            flock($handle, LOCK_EX);

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
        return $this->findOffsetPosition($key);
    }

    protected function _delete(array $keys): bool
    {
        $ok = true;

        foreach ($keys as $key) {
            if (false !== $offset = $this->findOffsetPosition($key)) {
                $ok = $this->_rewrite($this->fileName, '', $offset) && $ok;
            }
        }

        return $ok;
    }

    public function _clear(): bool
    {
        return rmdir($this->directory, true);
    }
}