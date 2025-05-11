<?php

namespace App\Aton\Service;

use App\Aton\Entity\City;
use App\Aton\Events\CityCreated;
use App\Aton\Events\CityUpdated;
use App\Aton\Repository\CityRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class CityService
{
    public function __construct(readonly CityRepositoryInterface $cityRepository,
                                private CacheItemPoolInterface   $cache,
                                private EventDispatcherInterface $eventDispatcher)
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
            $cities = $this->cityRepository->getAll();

            $cacheItem->set($cities)->expiresAfter(3600);
            $this->cache->save($cacheItem);
        }

        return $cities;
    }

    public function getCached(int $id): ?City
    {
        $cacheItem = $this->cache->getItem("cities:$id");

        if ($cacheItem->isHit()) {
            $city = $cacheItem->get();
            if ($city instanceof City) {
                return $city;
            }
        }

        return null;
    }

    public function create(array $data)
    {
        $this->cityRepository->create($data);

        $this->eventDispatcher->dispatch(new CityCreated());
    }

    public function update(int $id, array $data)
    {
        $this->cityRepository->update($id, $data);

        $this->eventDispatcher->dispatch(new CityUpdated);
    }
}