<?php

namespace App\Aton\Service;

use App\Aton\Repository\CityRepositoryInterface;
use App\Aton\Repository\CountryRepository;
use App\Core\Cache\CacheItem;
use Psr\Cache\CacheItemPoolInterface;

class CityService
{
    public function __construct(readonly CityRepositoryInterface     $cityRepository,
                                private CacheItemPoolInterface $cache,)
    {
    }

    //TODO - рефакторинг
    public function getForView(array $queryParam): array
    {
        if (isset($queryParam['filter']) || isset($queryParam['sort'])) {//Условие - заглушка

            return $this->cityRepository->getFiltered();
        }

        $cacheItem = $this->cache->getItem('cities');

        if ($cacheItem->isHit()) {

            return $cacheItem->get();

        } else {
            $cities= $this->cityRepository->findAll();

            $cacheItem->set($cities)->expiresAfter(3600);
            $this->cache->save($cacheItem);
        }

        return $cities;
    }
}