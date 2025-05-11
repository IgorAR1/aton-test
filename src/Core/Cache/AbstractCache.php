<?php

namespace App\Core\Cache;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

abstract class AbstractCache implements CacheInterface, CacheItemPoolInterface
{
    private array $deferredItems = [];

    abstract protected function _fetch(array $keys): iterable;
    abstract protected function _save(array $data): array|bool;
    abstract protected function _write(string $file, string $data): bool;
    abstract protected function _have(string $key): bool;
    abstract protected function _delete(array $keys): bool;
    abstract protected function _clear(): bool;

    protected function createCacheItem(string $key, mixed $value, bool $isHit): CacheItemInterface
    {
        return new CacheItem($key, $value, $isHit);
    }

    public function get(string $key, callable $callback): mixed
    {
        $cacheItem = $this->getItem($key);

        if ($cacheItem->isHit()) {

            return $cacheItem->get();
        } else {
           $value = $callback();
           $cacheItem->set($value);

           $this->save($cacheItem);
        }

        return $value;
    }

    public function getItem(string $key): CacheItemInterface
    {
        $isHit = false;
        $item['value'] = '';

        foreach ($this->_fetch([$key]) as $item) {
            $isHit = true;
        }


        return $this->createCacheItem($key, $item['value'], $isHit);
    }

    public function getItems(array $keys = []): iterable
    {
        $items = [];
        $fetched = $this->_fetch($keys);

        foreach ($fetched as $item) {
            $items[$item['key']] = $this->createCacheItem($item['key'], $item['value'], true);
        }

        return $items;
    }

    public function hasItem(string $key): bool
    {
        return $this->_have($key);
    }

    public function clear(): bool
    {
        return $this->_clear();
//        return rmdir($this->directory, true);
    }

    public function deleteItem(string $key): bool
    {
        return $this->deleteItems([$key]);
    }

    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            unset($this->deferredItems[$key]);
        }

        return $this->_delete($keys);
    }

    public function save(CacheItemInterface $item): bool
    {
        $this->saveDeferred($item);

        return $this->commit();
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        $this->deferredItems[] = $item;

        return true;
    }

    public function commit(): bool
    {
        $success = true;

        foreach ($this->deferredItems as $item) {
            $className = get_class($item);
            $item = (array)$item;

            $record['key'] = $item["key"];
            $record['value'] = $item["\x00$className\x00value"];
            $record['expiration'] = $item["\x00$className\x00expiration"];

            $success = $success && !$this->_save([$record]);
        }

        return $success;
    }
    protected function unserialize(string $data): mixed
    {
        $data = trim($data);

        if (false === $data = unserialize($data)) {
            throw new \Exception('Failed to unserialize data' . ' ' . $data);
        }

        return $data;
    }
    public function __destruct()
    {
        $this->commit();
    }
}