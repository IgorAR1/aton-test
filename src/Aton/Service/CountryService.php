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
        if (isset($queryParam['filter']) || isset($queryParam['sort'])) {//TODO Условие - заглушка \\мб наружу

            return $this->countryRepository->getFiltered();
        }

        $cacheItem = $this->cache->getItem('countries');

        if ($cacheItem->isHit()) {

            return $cacheItem->get();

        } else {
            $countries = $this->countryRepository->findAll();

            $cacheItem->set($countries)->expiresAfter(3600);
            $this->cache->save($cacheItem);
        }

        return $countries;
    }
}