<?php

namespace App\Aton\Service;

use App\Aton\Repository\CountryRepository;
use App\Aton\Repository\UserRepositoryInterface;
use App\Core\Cache\CacheItem;
use Psr\Cache\CacheItemPoolInterface;

class UserService
{
    public function __construct(readonly UserRepositoryInterface $userRepository,
                                private CacheItemPoolInterface   $cache,)
    {
    }

    public function getForView(array $queryParam): array
    {
        if (isset($queryParam['filter']) || isset($queryParam['sort'])) {//Условие - заглушка

            return $this->userRepository->getFiltered();
        }

        $cacheItem = $this->cache->getItem('users');

        if ($cacheItem->isHit()) {

            return $cacheItem->get();

        } else {
            $users = $this->userRepository->getAll();

            $cacheItem->set($users)->expiresAfter(3600);
            $this->cache->save($cacheItem);
        }

        return $users;
    }
}