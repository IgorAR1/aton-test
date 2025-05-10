<?php

namespace App\Aton\Service;

class CacheIndex
{
    public function __invoke(string $key, int $ttl, )
    {
        $cacheItem = $this->cache->getItem('users');

        if ($cacheItem->isHit()) {
            $users = $cacheItem->get();
        } else {
            $users = $this->userRepository->findAll();

            $cacheItem->set($users)->expiresAfter(3600);
            $this->cache->save($cacheItem);
        }
    }
}