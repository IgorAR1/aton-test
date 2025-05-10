<?php

namespace App\Aton\Service;

use App\Aton\Repository\CountryRepository;
use App\Core\Cache\CacheItem;
use Psr\Cache\CacheItemPoolInterface;

class CountryService
{
    public function __construct(readonly CountryRepository     $countryRepository,
                                private CacheItemPoolInterface $cache,)
    {
    }

    public function getForView(array $queryParam): array
    {
        if (isset($queryParam['filter']) || isset($queryParam['sort'])) {//Условие - заглушка

            return $this->countryRepository->getFiltered();
        }

        $cacheItem = $this->cache->getItem('countries');

        if ($cacheItem->isHit()) {

            return $cacheItem->get();
//            if (isset($queryParam['filter'])) {
//                $countries = array_filter($countries, function ($item) use ($queryParam) { ////У меня вопрос  - что лучше: сходить в бд с фильтрами - или отфильтровать коллекцию?
//                    foreach ($queryParam['filter'] as $key => $value) {}
//                });
//            }
        } else {
            $countries = $this->countryRepository->getFiltered();

            $cacheItem->set($countries)->expiresAfter(3600);
            $this->cache->save($cacheItem);
        }

        return $countries;
    }
}